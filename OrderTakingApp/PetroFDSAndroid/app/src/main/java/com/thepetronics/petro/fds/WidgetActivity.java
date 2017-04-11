package com.thepetronics.petro.fds;

/**
 * Created by danyal on 2/26/2016.
 */
import android.app.PendingIntent;
import android.appwidget.AppWidgetManager;
import android.appwidget.AppWidgetProvider;
import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.RemoteViews;

import org.apache.http.client.HttpClient;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.URL;
import java.net.URLConnection;
import java.util.Calendar;
import java.util.HashMap;

public class WidgetActivity extends AppWidgetProvider{
    SessionManager session;
    HashMap<String, String> user;
    String APIKEY_URL;
    private DBHelper mydb;
    private static final String MyOnClick = "myOnClickTag";
    String status_time, firstname, lastname, totalorder, order_date;
    @Override
    public void onReceive(Context context, Intent intent) {
        super.onReceive(context, intent);
        if (MyOnClick.equals(intent.getAction())) {
            session = new SessionManager(context);
            user = session.getUserDetails();
            // api url
            APIKEY_URL = user.get(SessionManager.KEY_API);
            // your onClick action is here
            mydb = new DBHelper(context);
            Log.d("MyService", "About to execute Task");
            String serverURL = APIKEY_URL+"/get_orders.php?total="+mydb.getTotalRows()+"";
            Log.d("serverURL", serverURL);
            new LongOperationUpdate().execute(serverURL);
        }
    }
    public void onUpdate(Context context, AppWidgetManager appWidgetManager,int[] appWidgetIds) {
        for (int widgetId : appWidgetIds) {
            RemoteViews mView = initViews(context, appWidgetManager, widgetId);
            appWidgetManager.updateAppWidget(widgetId, mView);
        }

        super.onUpdate(context, appWidgetManager, appWidgetIds);
    }
    protected PendingIntent getPendingSelfIntent(Context context, String action) {
        Intent intent = new Intent(context, getClass());
        intent.setAction(action);
        return PendingIntent.getBroadcast(context, 0, intent, 0);
    }
    private RemoteViews initViews(Context context,
                                  AppWidgetManager widgetManager, int widgetId) {

        RemoteViews mView = new RemoteViews(context.getPackageName(),
                R.layout.activity_widget);
        //mView.setOnClickPendingIntent(R.id.SyncWidget,
                //getPendingSelfIntent(context, MyOnClick));
        Intent intent = new Intent(context, WidgetService.class);
        intent.putExtra(AppWidgetManager.EXTRA_APPWIDGET_ID, widgetId);

        intent.setData(Uri.parse(intent.toUri(Intent.URI_INTENT_SCHEME)));
        mView.setRemoteAdapter(widgetId, R.id.widgetCollectionList, intent);

        return mView;
    }
    private class LongOperationUpdate  extends AsyncTask<String, Void, Void> {

        // Required initialization

        private final HttpClient Client = new DefaultHttpClient();
        private String Content;
        private String Error = null;
        String data = "";
        int sizeData = 0;

        protected void onPreExecute() {
            mydb.deleteAll("view_orders");
        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {

            /************ Make Post Call To Web Server ***********/
            BufferedReader reader = null;

            // Send data
            try {
                // Defined URL  where to send data
                URL url = new URL(urls[0]);
                // Send POST data request
                URLConnection conn = url.openConnection();
                conn.setDoOutput(true);
                OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
                wr.write(data);
                wr.flush();
                // Get the server response
                reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
                StringBuilder sb = new StringBuilder();
                String line = null;
                // Read Server Response
                while ((line = reader.readLine()) != null) {
                    // Append server response in string
                    sb.append(line + "\n");
                }
                Content = sb.toString();
            } catch (Exception ex) {
                Error = ex.getMessage();
            } finally {
                try {
                    reader.close();
                } catch (Exception ex) {
                }
            }

            /*****************************************************/
            return null;
        }
        protected void onPostExecute(Void unused) {

            if (Error != null) {
            } else {
                /****************** Start Parse Response JSON Data *************/

                String OutputData = "";
                JSONObject jsonResponse;

                try {

                    /****** Creates a new JSONObject with name/value mappings from the JSON string. ********/
                    jsonResponse = new JSONObject(Content);

                    /***** Returns the value mapped by name if it exists and is a JSONArray. ***/
                    /*******  Returns null otherwise.  *******/
                    JSONArray jsonMainNode = jsonResponse.optJSONArray("posts");

                    /*********** Process each JSON Node ************/

                    int lengthJsonArr = jsonMainNode.length();

                    for (int i = 0; i < lengthJsonArr; i++) {
                        /****** Get Object for each JSON node.***********/
                        JSONObject jsonChildNode = jsonMainNode.getJSONObject(i);

                        /******* Fetch node values **********/
                        String user_id = jsonChildNode.optString("user_id").toString();
                        String order_detail_id = jsonChildNode.optString("order_detail_id").toString();
                        String status = jsonChildNode.optString("status").toString();
                        status_time = jsonChildNode.optString("status_time").toString();
                        firstname = jsonChildNode.optString("firstname").toString();
                        lastname = jsonChildNode.optString("lastname").toString();
                        String address_1 = jsonChildNode.optString("add_1").toString();
                        String address_2 = jsonChildNode.optString("add_2").toString();
                        String city = jsonChildNode.optString("city").toString();
                        String post_code = jsonChildNode.optString("post_code").toString();
                        String loyalty_point = jsonChildNode.optString("loyalty_point").toString();
                        String about_order = jsonChildNode.optString("about_order").toString();
                        String payment_method = jsonChildNode.optString("payment_method").toString();
                        String decline_reason = jsonChildNode.optString("decline_reason").toString();
                        String order_time = jsonChildNode.optString("order_time").toString();
                        String total_price = jsonChildNode.optString("total_price").toString();
                        String currency = jsonChildNode.optString("currency").toString();
                        order_date = jsonChildNode.optString("date_order").toString();
                        totalorder = jsonChildNode.optString("total_order").toString();
                        String last_sync = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());

                        mydb.insert(user_id, order_detail_id, status, status_time, firstname, lastname, address_1, address_2, city, post_code, loyalty_point, about_order, payment_method, decline_reason, order_time, total_price, currency, order_date, last_sync);
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }
    }
}
