package com.thepetronics.petro.fds;

import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.CardView;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import org.apache.http.client.HttpClient;
import org.apache.http.impl.client.DefaultHttpClient;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.URL;
import java.net.URLConnection;
import java.util.HashMap;

public class AcceptDecline extends AppCompatActivity implements View.OnClickListener {

    SessionManager session;
    HashMap<String, String> user;
    String APIKEY_URL;
    private TextView BTN_ACCEPT = null;
    private TextView BTN_DECLINE = null;
    private TextView NAME = null;
    private TextView ADD_1 = null;
    private TextView ADD_2 = null;
    private TextView CITY = null;
    private TextView POSTCODE = null;
    private TextView ORDERSTATUS = null;
    String ID;
    String[] ID_GETDATA;
    private DBHelper mydb;
    private CardView ACCEPT_CARD, DECLINE_CARD;
    Spinner accept_spinner;
    EditText decline_reason;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_accept_decline);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            ID = extras.getString("ID");
        }
        session = new SessionManager(this);
        user = session.getUserDetails();
        // api url
        APIKEY_URL = user.get(SessionManager.KEY_API);
        mydb = new DBHelper(this);

        NAME = (TextView)findViewById(R.id.name);
        ADD_1 = (TextView)findViewById(R.id.add_1);
        ADD_2 = (TextView)findViewById(R.id.add_2);
        CITY = (TextView)findViewById(R.id.city);
        POSTCODE = (TextView)findViewById(R.id.postcode);
        ORDERSTATUS = (TextView)findViewById(R.id.status_order);

        ID_GETDATA = ID.split(":");
        Log.d("ID", ID_GETDATA[1].trim());
        Cursor rs = mydb.getData(ID_GETDATA[1].trim(), "view_orders");
        rs.moveToFirst();
        while (!rs.isAfterLast()) {
            NAME.setText("Full Name: "+rs.getString(5)+rs.getString(6));
            ADD_1.setText("Address 1: "+rs.getString(7));
            ADD_2.setText("Address 2: " + rs.getString(8));
            CITY.setText("City: "+rs.getString(9));
            POSTCODE.setText("Postcode: "+rs.getString(10));
            if(rs.getString(3).equals("0")){
                ORDERSTATUS.setTextColor(Color.CYAN);
                ORDERSTATUS.setText("Order Status: PENDING");
            }else if(rs.getString(3).equals("1")){
                ORDERSTATUS.setTextColor(Color.GREEN);
                ORDERSTATUS.setText("Order Status: ACCEPTED");
            }else if(rs.getString(3).equals("2")){
                ORDERSTATUS.setTextColor(Color.MAGENTA);
                ORDERSTATUS.setText("Order Status: DELIVERED");
            }else if(rs.getString(3).equals("3")){
                ORDERSTATUS.setTextColor(Color.RED);
                ORDERSTATUS.setText("Order Status: DECLINE");
            }
            rs.moveToNext();
        }
        ACCEPT_CARD = (CardView)findViewById(R.id.accept);
        DECLINE_CARD = (CardView)findViewById(R.id.decline);

        BTN_ACCEPT = (TextView)findViewById(R.id.btn_accept);
        BTN_DECLINE = (TextView)findViewById(R.id.btn_decline);

        BTN_ACCEPT.setOnClickListener(new ClickEvent());
        BTN_DECLINE.setOnClickListener(new ClickEvent());

        BTN_ACCEPT.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (event.getAction() == MotionEvent.ACTION_DOWN) {
                    ACCEPT_CARD.setCardElevation(0);
                } else if (event.getAction() == MotionEvent.ACTION_UP) {
                    ACCEPT_CARD.setCardElevation(24);
                }
                return false;
            }
        });

        BTN_DECLINE.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if(event.getAction() == MotionEvent.ACTION_DOWN){
                    DECLINE_CARD.setCardElevation(0);
                }
                else if(event.getAction() == MotionEvent.ACTION_UP){
                    DECLINE_CARD.setCardElevation(24);
                }
                return false;
            }
        });
    }

    class ClickEvent implements View.OnClickListener {
        public void onClick(View v) {
            if( v == BTN_ACCEPT ){
                AlertDialog.Builder builder = new AlertDialog.Builder(AcceptDecline.this);
                View view = AcceptDecline.this.getLayoutInflater().inflate(R.layout.accept_layout, null);
                accept_spinner=(Spinner) view.findViewById(R.id.time);
                builder.setView(view);
                builder.setMessage("SELECT TIME.")
                        .setCancelable(false)
                        .setPositiveButton("CANCEL", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();
                            }
                        })
                        .setNegativeButton("ACCEPT", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                String text = accept_spinner.getSelectedItem().toString();
                                String serverURL = APIKEY_URL+"/get_orders_status.php?status=1&id="+ID_GETDATA[1].trim()+"&time="+text+"";
                                new LongOperation().execute(serverURL);
                            }
                        });
                AlertDialog alert = builder.create();
                alert.show();
            }else if( v == BTN_DECLINE ){
                AlertDialog.Builder builder = new AlertDialog.Builder(AcceptDecline.this);
                View view = AcceptDecline.this.getLayoutInflater().inflate(R.layout.decline_layout, null);
                decline_reason=(EditText) view.findViewById(R.id.reason);
                builder.setView(view);
                builder.setMessage("ENTER DECLINE REASON.")
                        .setCancelable(false)
                        .setPositiveButton("CANCEL", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();
                            }
                        })
                        .setNegativeButton("DECLINE", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                String text = decline_reason.getText().toString().replace(" ", "%20");
                                Log.d("reson",text);
                                String serverURL = APIKEY_URL+"/get_orders_status.php?status=3&id=" + ID_GETDATA[1].trim() + "&reason=" + text + "";
                                new LongOperation().execute(serverURL);
                            }
                        });
                AlertDialog alert = builder.create();
                alert.getWindow().setSoftInputMode(WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_VISIBLE);
                alert.show();
            }
        }
    }



    @Override
    public void onDestroy() {
        super.onDestroy();

    }

    @Override
    public void onClick(View v) {
        // TODO Auto-generated method stub
        switch (v.getId()) {


        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_acceptdecline, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == android.R.id.home) {
            onBackPressed();
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    private class LongOperation  extends AsyncTask<String, Void, Void> {

        // Required initialization

        private final HttpClient Client = new DefaultHttpClient();
        private String Content;
        private String Error = null;
        String data = "";
        int sizeData = 0;


        protected void onPreExecute() {

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
                Snackbar.make(findViewById(android.R.id.content), Error, Snackbar.LENGTH_SHORT)
                        .setActionTextColor(Color.RED)
                        .show();
            }else{
                Toast.makeText(AcceptDecline.this, "STATUS CHANGED", Toast.LENGTH_LONG).show();
                Intent ViewOrders = new Intent(AcceptDecline.this, ViewOrders.class);
                startActivity(ViewOrders);
                finish();
            }
        }
    }
}
