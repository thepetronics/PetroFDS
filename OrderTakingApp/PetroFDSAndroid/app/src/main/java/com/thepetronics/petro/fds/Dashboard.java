package com.thepetronics.petro.fds;

import android.accounts.Account;
import android.accounts.AccountManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import java.util.HashMap;

public class Dashboard extends AppCompatActivity {
    SessionManager session;
    private DBHelper mydb;
    private AlertDialog alertDialog;
    private Account account;
    HashMap<String, String> user;
    String APIKEY_URL;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);
        mydb = new DBHelper(this);
        session = new SessionManager(getApplicationContext());
        user = session.getUserDetails();
        // username
        String USER_NAME = user.get(SessionManager.KEY_NAME);

        // api url
        APIKEY_URL = user.get(SessionManager.KEY_API);

        // Dashboard News feed button
        Button ViewOrders = (Button) findViewById(R.id.view_orders);

        // Dashboard Friends button
        Button AdminDash = (Button) findViewById(R.id.admin_dash);

        // Listening to News Feed button click
        ViewOrders.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {
                // Launching News Feed Screen
                Intent i = new Intent(getApplicationContext(), ViewOrders.class);
                startActivity(i);
            }
        });

        // Listening Friends button click
        AdminDash.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {
                // Launching News Feed Screen
                Intent i = new Intent(getApplicationContext(), Admin_dash.class);
                startActivity(i);
            }
        });

        ConnectivityManager cn=(ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo nf=cn.getActiveNetworkInfo();
        if(nf != null && nf.isConnected()==true ) {
            Toast.makeText(this, "Data Downloading Start.", Toast.LENGTH_SHORT).show();
            Intent intent = new Intent(Intent.ACTION_SYNC, null, this, DownloadService.class);
            startService(intent);
            Toast.makeText(this, "Data Downloading Completed.", Toast.LENGTH_SHORT).show();
        }else{
            AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(Dashboard.this);
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

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.dashboard, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_sync) {
            ConnectivityManager cn=(ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
            NetworkInfo nf=cn.getActiveNetworkInfo();
            if(nf != null && nf.isConnected()==true ) {
                Toast.makeText(this, "Data Downloading Start.", Toast.LENGTH_SHORT).show();
                /* Starting Download Service */
                Intent intent = new Intent(Intent.ACTION_SYNC, null, this, DownloadService.class);
                startService(intent);
                Toast.makeText(this, "Data Downloading Completed.", Toast.LENGTH_SHORT).show();
            }else{
                AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(Dashboard.this);
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
            return true;
        } else if (id == R.id.action_logout) {
            final AccountManager accountManager = AccountManager.get(getApplicationContext());
            final String accountType = getString(R.string.account_Type);

            final Account[] availableAccounts = accountManager.getAccountsByType(accountType);
            for (final Account availableAccount : availableAccounts) {
                accountManager.removeAccount(availableAccount, null, null);
            }
            Toast.makeText(this, "Going Logout.", Toast.LENGTH_SHORT).show();
            session.logoutUser();

            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
