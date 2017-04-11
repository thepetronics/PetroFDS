package com.thepetronics.petro.fds;

import android.app.PendingIntent;
import android.app.SearchManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.support.design.widget.FloatingActionButton;
import android.support.v4.view.MenuItemCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.SearchView;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;

import com.google.gson.Gson;

import java.io.Reader;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.GregorianCalendar;
import java.util.HashMap;

public class ViewOrders extends AppCompatActivity implements SearchView.OnQueryTextListener {

    private RecyclerView mRecyclerView;
    private RecyclerView.Adapter mAdapter;
    private RecyclerView.LayoutManager mLayoutManager;
    private ArrayList results;
    private static String LOG_TAG = "CardViewActivity";
    private DBHelper mydb;
    private FloatingActionButton Sync;
    private AlertDialog alertDialog;
    private Toolbar toolbar;
    private TextView toolbar_heading;
    GregorianCalendar calendar;
    private PendingIntent pendingIntent;
    String ID,Status_order;
    Handler mHandler;
    SessionManager session;
    HashMap<String, String> user;
    String APIKEY_URL;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_vieworders);
        toolbar = (Toolbar) findViewById(R.id.toolbar_in);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        toolbar.setTitleTextColor(getResources().getColor(R.color.White));
        session = new SessionManager(getApplicationContext());
        user = session.getUserDetails();
        // api url
        APIKEY_URL = user.get(SessionManager.KEY_API);
        calendar = (GregorianCalendar) Calendar.getInstance();
        toolbar_heading = (TextView) findViewById(R.id.toolbar_heading);
        mydb = new DBHelper(this);
        Cursor rs_date = mydb.getAllData("view_orders");
        if(rs_date.moveToLast()) {
            toolbar_heading.setText("Last Sync: "+ rs_date.getString(19));
        }else{
            toolbar_heading.setText("Please press sync button to sync data.");
        }
        mRecyclerView = (RecyclerView) findViewById(R.id.my_recycler_view);
        mRecyclerView.setHasFixedSize(true);
        mLayoutManager = new LinearLayoutManager(this);
        mRecyclerView.setLayoutManager(mLayoutManager);
        mAdapter = new MyRecyclerViewAdapter(getDataSet());
        mRecyclerView.setAdapter(mAdapter);

        ConnectivityManager cn=(ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo nf=cn.getActiveNetworkInfo();
        if(nf != null && nf.isConnected()==true ) {
            String serverURL = APIKEY_URL+"/get_orders.php?total="+mydb.getTotalRows()+"";
            new InsertData().execute(serverURL);
        }

        Sync = (FloatingActionButton)findViewById(R.id.sync_all);
        Sync.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ConnectivityManager cn=(ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
                NetworkInfo nf=cn.getActiveNetworkInfo();
                if(nf != null && nf.isConnected()==true ) {
                    String serverURL = APIKEY_URL+"/get_orders.php?total="+mydb.getTotalRows()+"";
                    new InsertData().execute(serverURL);
                }else{
                    AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(ViewOrders.this);
                    alertDialogBuilder.setMessage("Please Check your internet connection");
                    alertDialogBuilder.setPositiveButton("Ok", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface arg0, int arg1) {
                            alertDialog.dismiss();
                        }
                    });
                    alertDialog = alertDialogBuilder.create();
                    alertDialog.show();
                }
            }
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        ConnectivityManager cn=(ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo nf=cn.getActiveNetworkInfo();
        if(nf != null && nf.isConnected()==true ) {
            String serverURL = APIKEY_URL+"/get_orders.php?total="+mydb.getTotalRows()+"";
            new InsertData().execute(serverURL);
        }
        ((MyRecyclerViewAdapter) mAdapter).setOnItemClickListener(new MyRecyclerViewAdapter
                .MyClickListener() {
            @Override
            public void onItemClick(int position, View v) {
                TextView id_text = (TextView) v.findViewById(R.id.id);
                ID = id_text.getText().toString();

                AlertDialog.Builder builder = new AlertDialog.Builder(ViewOrders.this);
                builder.setMessage("SELECT OPTIONS.")
                        .setCancelable(false)
                        .setPositiveButton("View Details", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                Intent Invoice = new Intent(ViewOrders.this, Invoice.class);
                                Invoice.putExtra("ID",ID);
                                startActivity(Invoice);
                            }
                        })
                        .setNegativeButton("Accept/Decline", new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                Intent Invoice = new Intent(ViewOrders.this, AcceptDecline.class);
                                Invoice.putExtra("ID",ID);
                                startActivity(Invoice);
                            }
                        });
                AlertDialog alert = builder.create();
                alert.show();
                Log.i(LOG_TAG, " Clicked on Item " + position);
            }
        });
    }

    private ArrayList<DataObject> getDataSet() {
        results = new ArrayList<DataObject>();
        Cursor rs = mydb.getAllData("view_orders");
        rs.moveToFirst();
        while (!rs.isAfterLast()) {
            if(rs.getString(3).equals("0")){
                Status_order = "PENDING";
            }else if(rs.getString(3).equals("1")){
                Status_order = "ACCEPTED";
            }else if(rs.getString(3).equals("2")){
                Status_order = "DELIVERED";
            }else if(rs.getString(3).equals("3")){
                Status_order = "DECLINE";
            }
            DataObject DATA = new DataObject("FULL NAME: "+rs.getString(5)+" "+rs.getString(6),"ID: "+rs.getString(2),"STATUS: "+Status_order,"ADDRESS: "+ rs.getString(7),"DATE&TIME: "+rs.getString(18));
            results.add(DATA);
            rs.moveToNext();
        }
        return results;
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        MenuInflater menuInflater = getMenuInflater();
        menuInflater.inflate(R.menu.menu_vieworders, menu);
        MenuItem searchItem = menu.findItem(R.id.action_search);

        SearchManager searchManager = (SearchManager) ViewOrders.this.getSystemService(Context.SEARCH_SERVICE);

        SearchView searchView = null;
        if (searchItem != null) {
            searchView = (SearchView) searchItem.getActionView();

        }
        if (searchView != null) {
            searchView.setSearchableInfo(searchManager.getSearchableInfo(ViewOrders.this.getComponentName()));
        }
        searchView.setOnQueryTextListener(this);
        MenuItemCompat.setOnActionExpandListener(searchItem,
                new MenuItemCompat.OnActionExpandListener() {
                    @Override
                    public boolean onMenuItemActionCollapse(MenuItem item) {
                        // Do something when collapsed
                        ((MyRecyclerViewAdapter) mAdapter).setFilter(results);
                        return true; // Return true to collapse action view
                    }

                    @Override
                    public boolean onMenuItemActionExpand(MenuItem item) {
                        // Do something when expanded
                        return true; // Return true to expand action view
                    }
                });
        return super.onCreateOptionsMenu(menu);
    }

    public boolean onQueryTextChange(String newText) {
        final ArrayList<DataObject> filteredModelList = filter(results, newText);
        ((MyRecyclerViewAdapter) mAdapter).setFilter(filteredModelList);
        return true;
    }

    public boolean onQueryTextSubmit(String query) {
        return false;
    }

    private ArrayList<DataObject> filter(ArrayList<DataObject> models, String query) {
        query = query.toLowerCase();

        final ArrayList<DataObject> filteredModelList = new ArrayList<>();
        for (DataObject model : models) {
            final String text = model.getmText1().toLowerCase();
            if (text.contains(query)) {
                filteredModelList.add(model);
            }
        }
        return filteredModelList;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if(id == android.R.id.home){
            onBackPressed();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    private class InsertData extends AsyncTask<String, Void, Void> {
        String data = "";
        protected void onPreExecute() {
            toolbar_heading.setText("System is Downloading Files");
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
            mAdapter = new MyRecyclerViewAdapter(getDataSet());
            mRecyclerView.setAdapter(mAdapter);
            toolbar_heading.setText("Download Complete");
            new Handler().postDelayed(new Runnable() {
                @Override
                public void run() {
                    Cursor rs_post = mydb.getAllData("view_orders");
                    if (rs_post.moveToLast()) {
                        toolbar_heading.setText("Last Sync: " + rs_post.getString(19));
                    } else {
                        toolbar_heading.setText("Unable To Sync.");
                    }
                }
            }, 3000);
        }
    }
}
