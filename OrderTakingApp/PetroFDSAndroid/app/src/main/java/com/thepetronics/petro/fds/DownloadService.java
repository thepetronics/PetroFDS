package com.thepetronics.petro.fds;

/**
 * Created by MuhammadDanyal on 7/24/2016.
 */
import android.app.IntentService;
import android.content.Intent;
import android.util.Log;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.Calendar;
import java.util.HashMap;

public class DownloadService extends IntentService {

    SessionManager session;
    HashMap<String, String> user;
    String APIKEY_URL;
    public static final int STATUS_RUNNING = 0;
    public static final int STATUS_FINISHED = 1;
    public static final int STATUS_ERROR = 2;
    private DBHelper mydb;
    private JSONArray url1 = null;
    private JSONArray url2 = null;
    private JSONArray url3 = null;
    private JSONArray url4 = null;
    private static final String TAG = "DownloadService";

    public DownloadService() {
        super(DownloadService.class.getName());
    }

    @Override
    protected void onHandleIntent(Intent intent) {
        session = new SessionManager(this);
        user = session.getUserDetails();
        // api url
        APIKEY_URL = user.get(SessionManager.KEY_API);
        mydb = new DBHelper(this);
        Log.d(TAG, "Service Started!");
        String serverURL = APIKEY_URL+"/Reports/get_sales.php";
        Log.d("salesURL", serverURL);
        Sales(serverURL);
        String serverURL_Customer = APIKEY_URL+"/Reports/get_top_customer.php";
        Log.d("customerURL",serverURL_Customer);
        Customer(serverURL_Customer);
        String serverURL_PR = APIKEY_URL+"/Reports/get_top_product.php";
        Log.d("productURL",serverURL_PR);
        Product(serverURL_PR);
        String serverURL_OR = APIKEY_URL+"/Reports/get_order_info.php";
        Log.d("orderinfoURL",serverURL_OR);
        Orderinfo(serverURL_OR);
        Log.d(TAG, "Service Stopping!");
        this.stopSelf();
    }
    private void Sales(String url){
        Log.i("Sales","DownloadStart");

        JSONParser jParser = new JSONParser();

        JSONObject json1 = jParser.getJSONFromUrl(url);


        try {
            mydb.deleteAll("sales");
            url1 = json1.optJSONArray("posts");

            // looping through all posts according to the json object returned
            for (int j = 0; j < url1.length(); j++) {
                JSONObject d = url1.getJSONObject(j);

                // gets the content of each tag
                String this_month = d.optString("this_month").toString();
                String last_month = d.optString("last_month").toString();
                String this_year = d.optString("this_year").toString();
                String last_year = d.optString("last_year").toString();
                String last_sync = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());
                mydb.insert_sales(this_month, last_month, this_year, last_year, last_sync);
            }

        } catch (Exception e) {

        }
        Log.i("Sales","END");
    }
    private void Customer(String url){
        Log.i("Customer","DownloadingStart");

        JSONParser jParser = new JSONParser();

        JSONObject json1 = jParser.getJSONFromUrl(url);


        try {
            mydb.deleteAll("customer");
            url2 = json1.optJSONArray("posts");

            // looping through all posts according to the json object returned
            for (int j = 0; j < url2.length(); j++) {
                JSONObject d = url2.getJSONObject(j);

                // gets the content of each tag
                String user_fullname = d.optString("user_fullname").toString();
                String last_sync = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());
                mydb.insert_customer(user_fullname, last_sync);
            }

        } catch (Exception e) {

        }
        Log.i("Customer","END");
    }
    private void Product(String url){
        Log.i("Product","DownloadingStart");

        JSONParser jParser = new JSONParser();

        JSONObject json1 = jParser.getJSONFromUrl(url);


        try {
            mydb.deleteAll("product");
            url3 = json1.optJSONArray("posts");

            // looping through all posts according to the json object returned
            for (int j = 0; j < url3.length(); j++) {
                JSONObject d = url3.getJSONObject(j);

                // gets the content of each tag
                String name = d.optString("name").toString();
                String last_sync = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());
                mydb.insert_pr(name, last_sync);
            }

        } catch (Exception e) {

        }
        Log.i("Product","END");
    }
    private void Orderinfo(String url){
        Log.i("Orderinfo","DownloadingStart");

        JSONParser jParser = new JSONParser();

        JSONObject json1 = jParser.getJSONFromUrl(url);


        try {
            mydb.deleteAll("orderinfo");
            url4 = json1.optJSONArray("posts");

            // looping through all posts according to the json object returned
            for (int j = 0; j < url4.length(); j++) {
                JSONObject d = url4.getJSONObject(j);

                // gets the content of each tag
                String fullname = d.optString("fullname").toString();
                String grand_total = d.optString("grand_total").toString();
                String status = d.optString("status").toString();
                String lifetime_sales = d.optString("lifetime_sales").toString();
                String avg_sales = d.optString("avg_sales").toString();
                String last_sync = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());
                mydb.insert_orderinfo(fullname, grand_total, status, lifetime_sales, avg_sales, last_sync);
            }

        } catch (Exception e) {

        }
        Log.i("Orderinfo","END");
    }
}
