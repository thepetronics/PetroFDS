package com.thepetronics.petro.fds;

import android.accounts.Account;
import android.accounts.AccountAuthenticatorResponse;
import android.accounts.AccountManager;
import android.app.ProgressDialog;
import android.content.ContentResolver;
import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Build;
import android.support.design.widget.Snackbar;
import android.support.design.widget.TextInputLayout;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.firebase.iid.FirebaseInstanceId;
import com.google.gson.Gson;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.io.Reader;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.List;

public class Login extends AppCompatActivity implements View.OnClickListener {

    private EditText user, pass, api_url;
    private TextView mSubmit, Copyrights, Guide_url;
    private ImageView imageView;
    private CardView login_card;
    private TextInputLayout layout_username, layout_password, layout_url;
    private Calendar Cal;
    // Progress Dialog
    private ProgressDialog pDialog;
    private SimpleDateFormat dateformat;
    private Account account;
    private String Edit_copyrights, URL;
    private AccountManager am;
    private Exception exceptionToBeThrown;
    SessionManager session;
    HashMap<String, String> details;
    private DBHelper mydb;

    // JSON parser class
    JSONParser jsonParser = new JSONParser();;

    //JSON element ids from repsonse of php script:
    private static final String TAG_SUCCESS = "success";
    private static final String TAG_MESSAGE = "message";
    private static final String TAG_MES = "mes";
    private static final String TAG_ID = "id";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        mydb = new DBHelper(this);
        imageView = (ImageView)findViewById(R.id.logo);
        // Session Manager
        session = new SessionManager(getApplicationContext());
        Cal = Calendar.getInstance();
        Edit_copyrights = String.format(getResources().getString(R.string.copy_rights), Cal.get(Calendar.YEAR));
        //setup input fields
        user = (EditText)findViewById(R.id.username);
        pass = (EditText)findViewById(R.id.password);
        api_url = (EditText)findViewById(R.id.url);
        login_card = (CardView)findViewById(R.id.login_card);
        Copyrights = (TextView)findViewById(R.id.copyrights);
        Guide_url = (TextView)findViewById(R.id.guide_url);
        layout_username = (TextInputLayout)findViewById(R.id.layout_username);
        layout_password = (TextInputLayout)findViewById(R.id.layout_password);
        layout_url = (TextInputLayout)findViewById(R.id.layout_url);
        //setup buttons
        mSubmit = (TextView)findViewById(R.id.login);
        mSubmit.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if(event.getAction() == MotionEvent.ACTION_DOWN){
                    login_card.setCardElevation(0);
                }
                else if(event.getAction() == MotionEvent.ACTION_UP){
                    login_card.setCardElevation(24);
                }
                return false;
            }
        });
        Animation translateAnim = AnimationUtils.loadAnimation(getApplicationContext(),
                R.anim.raise);
        imageView.startAnimation(translateAnim);
        translateAnim.setAnimationListener(new Animation.AnimationListener() {
            @Override
            public void onAnimationStart(Animation arg0) {

            }

            @Override
            public void onAnimationRepeat(Animation arg0) {
            }

            @Override
            public void onAnimationEnd(Animation arg0) {
                user.setVisibility(View.VISIBLE);
                pass.setVisibility(View.VISIBLE);
                api_url.setVisibility(View.VISIBLE);
                mSubmit.setVisibility(View.VISIBLE);
                Copyrights.setVisibility(View.VISIBLE);
                Guide_url.setVisibility(View.VISIBLE);
                login_card.setVisibility(View.VISIBLE);
                layout_username.setVisibility(View.VISIBLE);
                layout_password.setVisibility(View.VISIBLE);
                layout_url.setVisibility(View.VISIBLE);
                Copyrights.setText(Edit_copyrights);
            }
        });

        Toast.makeText(getApplicationContext(), "Login Status: " + session.isLoggedIn(), Toast.LENGTH_LONG).show();
        if(session.isLoggedIn())
        {
            am = AccountManager.get(getBaseContext());
            session = new SessionManager(getApplicationContext());
            session.checkLogin();
            details = session.getUserDetails();
            String accountName = details.get(SessionManager.KEY_NAME);
            Account[] accounts = am.getAccountsByType(getResources().getString(R.string.account_Type));
            for(Account account : accounts) {
                if(account.name.equals(accountName)){
                    Intent d = new Intent(this, Start_screen.class);
                    startActivity(d);
                    finish();
                }
            }
        }

        //register listeners
        mSubmit.setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        // TODO Auto-generated method stub
        switch (v.getId()) {
            case R.id.login:
                String username = user.getText().toString();
                String password = pass.getText().toString();
                String url_api = api_url.getText().toString();
                if(username.matches("")){
                    user.setError(getString(R.string.error_username));
                }else if(password.matches("")){
                    pass.setError(getString(R.string.error_password));
                }else if(url_api.matches("")){
                    api_url.setError(getString(R.string.error_api_url));
                }else {
                    new AttemptLogin().execute(username, password, url_api);
                }
                break;
            default:
                break;
        }
    }

    class AttemptLogin extends AsyncTask<String, String, String> {

        /**
         * Before starting background thread Show Progress Dialog
         * */
        boolean failure = false;

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            pDialog = new ProgressDialog(Login.this);
            pDialog.setMessage("Attempting login...");
            pDialog.setIndeterminate(false);
            pDialog.setCancelable(false);
            pDialog.show();
        }

        @Override
        protected String doInBackground(String... args) {
            // TODO Auto-generated method stub
            // Check for success tag
            int success;
            String username = args[0];
            String password = args[1];
            String url_api = args[2];

            try {
                URL = url_api;

                // Building Parameters
                List<NameValuePair> params = new ArrayList<NameValuePair>();
                params.add(new BasicNameValuePair("username", username));
                params.add(new BasicNameValuePair("password", password));
                params.add(new BasicNameValuePair("token", FirebaseInstanceId.getInstance().getToken()));
                params.add(new BasicNameValuePair("device_id", Build.SERIAL));

                Log.d("request!", "starting");
                // getting product details by making HTTP request
                JSONObject json = jsonParser.makeHttpRequest(
                        URL+"/mobile/login.php", "POST", params);

                // check your log for json response
                Log.d("Login attempt", json.toString());

                // json success tag
                success = json.getInt(TAG_SUCCESS);
                if (success == 1) {
                    account = new Account(username, getString(R.string.account_Type));
                    // = AccountManager.get(Login.this);
                    am = (AccountManager) Login.this.getSystemService(
                                    ACCOUNT_SERVICE);
                    boolean accountCreated = am.addAccountExplicitly(account, password, null);
                    ContentResolver.setMasterSyncAutomatically(true);
                    ContentResolver.setIsSyncable(account, "com.thepetronics.petro.fds", 1);
                    ContentResolver.setSyncAutomatically(
                            account, "com.thepetronics.petro.fds", true);
                    ContentResolver.addPeriodicSync(account, "com.thepetronics.petro.fds", Bundle.EMPTY, 60);
                    ContentResolver.requestSync(account, "com.thepetronics.petro.fds", Bundle.EMPTY);
                    String serverURL = URL+"/get_orders.php?total=0";
                    new InsertData().execute(serverURL);
                    Bundle extras = getIntent().getExtras();
                    if (extras != null) {
                        if (accountCreated) {  //Pass the new account back to the account manager
                            AccountAuthenticatorResponse response = extras.getParcelable(AccountManager.KEY_ACCOUNT_AUTHENTICATOR_RESPONSE);
                            Bundle result = new Bundle();
                            result.putString(AccountManager.KEY_ACCOUNT_NAME, username);
                            result.putString(AccountManager.KEY_ACCOUNT_TYPE, getString(R.string.account_Type));
                            response.onResult(result);
                        }
                        finish();
                    }
                    Log.d("Login Successful!", json.toString());
                    String id = json.getString(TAG_ID);
                    session.createLoginSession(id, username, url_api);
                    Snackbar.make(findViewById(android.R.id.content), "Login Successful!", Snackbar.LENGTH_SHORT)
                            .setActionTextColor(R.color.ColorActionbar)
                            .show();
                    // Staring MainActivity
                    try {
                        pDialog.dismiss();
                        Thread.currentThread();
                        Thread.sleep(2000);
                        Intent i = new Intent(getApplicationContext(), Dashboard.class);
                        startActivity(i);
                        finish();
                    } catch (InterruptedException e) {
                        // TODO Auto-generated catch block
                        e.printStackTrace();
                    }
                    return json.getString(TAG_MES);
                } else {
                    Snackbar.make(findViewById(android.R.id.content), R.string.invalid_credentials, Snackbar.LENGTH_SHORT)
                            .setActionTextColor(Color.RED)
                            .show();
                    Log.d("Login Failure!", json.getString(TAG_MES));
                    return json.getString(TAG_MES);

                }
            } catch (Exception e) {
                exceptionToBeThrown = e;
            }

            return null;

        }
        /**
         * After completing background task Dismiss the progress dialog
         * **/
        protected void onPostExecute(String file_url) {
            // dismiss the dialog once product deleted
            pDialog.dismiss();
            if (exceptionToBeThrown != null) {
                try {
                    Snackbar.make(findViewById(android.R.id.content), "I Think You Might Have Some Problem", Snackbar.LENGTH_SHORT)
                            .setActionTextColor(Color.RED)
                            .show();
                    throw exceptionToBeThrown;
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            if (file_url != null){
                Toast.makeText(Login.this, file_url, Toast.LENGTH_LONG).show();
            }

        }

    }

    private class InsertData extends AsyncTask<String, Void, Void> {
        String data = "";
        protected void onPreExecute() {
        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {
            Gson Json = new Gson();
            Reader reader = API.getData(urls[0]);
            ResponseHolder RH = Json.fromJson(reader, ResponseHolder.class);
            if(RH.getEvents() != null){
                mydb.deleteAll("view_orders");
            }
            for(OrdersPost Data: RH.getEvents()){
                String user_id = Data.getUser_id();
                String order_detail_id = Data.getOrder_detail_id();
                String status = Data.getStatus();
                String status_time = Data.getStatus_time();
                String firstname = Data.getFirstname();
                String lastname = Data.getLastname();
                String address_1 = Data.getAdd_1();
                String address_2 = Data.getAdd_2();
                String city = Data.getCity();
                String post_code = Data.getPost_code();
                String loyalty_point = Data.getLoyalty_point();
                String about_order = Data.getAbout_order();
                String payment_method = Data.getPayment_method();
                String decline_reason = Data.getDecline_reason();
                String order_time = Data.getOrder_time();
                String total_price = Data.getTotal_price();
                String currency = Data.getCurrency();
                String order_date = Data.getDate_order();
                String last_sync = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());

                mydb.insert(user_id,order_detail_id,status,status_time,firstname,lastname,address_1,address_2,city,post_code,loyalty_point,about_order,payment_method,decline_reason,order_time,total_price,currency,order_date,last_sync);
            }
            return null;
        }
        protected void onPostExecute(Void unused) {

        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_login, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
