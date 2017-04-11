package com.thepetronics.petro.fds;

import android.app.DatePickerDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.database.Cursor;
import android.graphics.Color;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Handler;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.CardView;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.Calendar;

public class Sync_data extends AppCompatActivity {

    private EditText from_date;
    private EditText to_date;
    private DatePicker dpResult;
    private TextView Sync_films, title_head;
    private CardView cardView;
    private int year;
    private int month;
    private int day;
    private JSONArray url1 = null;
    private JSONArray url2 = null;
    static final int DATE_DIALOG_ID = 999;
    static final int DATE_DIALOG_ID_2 = 888;
    private DBHelper mydb;
    private AlertDialog alertDialog;
    private String serverURL1, serverURL2, Content;
    private Exception exceptionToBeThrown;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sync_data);
        from_date = (EditText) findViewById(R.id.from_films);
        to_date = (EditText) findViewById(R.id.to_films);
        Sync_films = (TextView)findViewById(R.id.Sync_films);
        title_head = (TextView)findViewById(R.id.title_head);
        cardView = (CardView) findViewById(R.id.films_sync_card);
        mydb = new DBHelper(this);
        setCurrentDateOnView();
        addListenerOnButton();
        Sync_films.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (event.getAction() == MotionEvent.ACTION_DOWN) {
                    cardView.setCardElevation(0);
                } else if (event.getAction() == MotionEvent.ACTION_UP) {
                    cardView.setCardElevation(24);
                }
                return false;
            }
        });
        Sync_films.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                String fromdate = from_date.getText().toString();
                String todate = to_date.getText().toString();
                //mydb.deleteAll_films_sync();
                //mydb.insert_films_sync(fromdate, todate);
                if (fromdate.matches("")) {
                    from_date.setError("Please Select From Date");
                } else if (todate.matches("")) {
                    to_date.setError("Please Select To Date");
                } else {
                    ConnectivityManager cn = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
                    NetworkInfo nf = cn.getActiveNetworkInfo();
                    if (nf != null && nf.isConnected() == true) {
                        new DownloadData_Films().execute();
                    } else {
                        AlertDialog.Builder alertDialogBuilder = new AlertDialog.Builder(Sync_data.this);
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
            }
        });
    }

    // display current date
    public void setCurrentDateOnView() {
        dpResult = (DatePicker) findViewById(R.id.datePicker);

        final Calendar c = Calendar.getInstance();
        year = c.get(Calendar.YEAR);
        month = c.get(Calendar.MONTH);
        day = c.get(Calendar.DAY_OF_MONTH);

        Cursor rs = mydb.getAllData("view_orders");
        if(rs.moveToLast()) {
            from_date.setText(rs.getString(1));
            to_date.setText(rs.getString(2));
        }else {
            if ((day < 10) && (month < 9)){
                String day_zero = String.valueOf("0" + day);
                month = month + 1;
                String mont_zero = String.valueOf("0" + month);
                // set current date into textview
                from_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
                to_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
            }else if (month < 9) {
                month = month + 1;
                String mont_zero = String.valueOf("0" + month);
                // set current date into textview
                from_date.setText(new StringBuilder().append(day)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
                to_date.setText(new StringBuilder().append(day)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
            }else if (day < 10){
                String day_zero = String.valueOf("0" + day);
                // set current date into textview
                from_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
                to_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
            }else{
                // set current date into textview
                from_date.setText(new StringBuilder().append(day)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
                to_date.setText(new StringBuilder().append(day)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
            }
        }

        // set current date into datepicker
        dpResult.init(year, month, day, null);

    }

    public void addListenerOnButton() {

        from_date.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            public void onFocusChange(View v, boolean gainFocus) {
                //onFocus
                if (gainFocus) {
                    showDialog(DATE_DIALOG_ID);
                }
            }
        });

        from_date.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                showDialog(DATE_DIALOG_ID);

            }

        });

        to_date.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            public void onFocusChange(View v, boolean gainFocus) {
                //onFocus
                if (gainFocus) {
                    showDialog(DATE_DIALOG_ID_2);
                }
            }
        });

        to_date.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                showDialog(DATE_DIALOG_ID_2);

            }

        });

    }

    @Override
    protected Dialog onCreateDialog(int id) {
        switch (id) {
            case DATE_DIALOG_ID:
                // set date picker as current date
                DatePickerDialog dlg = new DatePickerDialog(this, datePickerListener,
                        year, month,day);
                /*int month_disable = this.getResources().getIdentifier("android:id/month", null, null);
                int day_disable = this.getResources().getIdentifier("android:id/day", null, null);
                if(month_disable != 0){
                    View monthPicker = dlg.getDatePicker().findViewById(month_disable);
                    View dayPicker = dlg.getDatePicker().findViewById(day_disable);
                    if(monthPicker != null){
                        monthPicker.setVisibility(View.GONE);
                        dayPicker.setVisibility(View.GONE);
                    }
                }*/
                return dlg;
            case DATE_DIALOG_ID_2:
                // set date picker as current date
                DatePickerDialog dlg2 = new DatePickerDialog(this, datePickerListener2,
                        year, month,day);
                return dlg2;
        }
        return null;
    }

    private DatePickerDialog.OnDateSetListener datePickerListener
            = new DatePickerDialog.OnDateSetListener() {

        // when dialog box is closed, below method will be called.
        public void onDateSet(DatePicker view, int selectedYear,
                              int selectedMonth, int selectedDay) {
            year = selectedYear;
            month = selectedMonth;
            day = selectedDay;
            if((day < 10) && (month < 9)){
                String day_zero = String.valueOf("0" + day);
                month = month + 1;
                String mont_zero = String.valueOf("0" + month);
                from_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
            }else if (month < 9) {
                month = month + 1;
                String mont_zero = String.valueOf("0" + month);
                from_date.setText(new StringBuilder().append(day)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
            }else if(day < 10){
                String day_zero = String.valueOf("0" + day);
                from_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
            }else{
                from_date.setText(new StringBuilder().append(day)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
            }
            // set selected date into datepicker also
            dpResult.init(year, month, day, null);

        }
    };

    private DatePickerDialog.OnDateSetListener datePickerListener2
            = new DatePickerDialog.OnDateSetListener() {

        // when dialog box is closed, below method will be called.
        public void onDateSet(DatePicker view, int selectedYear,
                              int selectedMonth, int selectedDay) {
            year = selectedYear;
            month = selectedMonth;
            day = selectedDay;
            if((day < 10) && (month < 9)){
                String day_zero = String.valueOf("0" + day);
                month = month + 1;
                String mont_zero = String.valueOf("0" + month);
                to_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
            }else if (month < 9) {
                month = month + 1;
                String mont_zero = String.valueOf("0" + month);
                to_date.setText(new StringBuilder().append(day)
                        .append("/").append(mont_zero)
                        .append("/").append(year)
                        .append(" "));
            }else if(day < 10){
                String day_zero = String.valueOf("0" + day);
                to_date.setText(new StringBuilder().append(day_zero)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
            }else{
                to_date.setText(new StringBuilder().append(day)
                        .append("/").append(month + 1)
                        .append("/").append(year)
                        .append(" "));
            }
            // set selected date into datepicker also
            dpResult.init(year, month, day, null);

        }
    };

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_sync_data, menu);
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

    public void updateMonOverview() {

        //mydb.deleteAll();

        serverURL1 = "http://films.mecsindh.petro.pk/films/mobile/webservice/mon_status1.php";

        JSONParser jParser = new JSONParser();

        JSONObject json1 = jParser.getJSONFromUrl(serverURL1);


        try {
            url1 = json1.optJSONArray("posts1");

            // looping through all posts according to the json object returned
            for (int j = 0; j < url1.length(); j++) {
                JSONObject d = url1.getJSONObject(j);

                // gets the content of each tag
                String this_week = d.optString("this_week").toString();
                String last_week = d.optString("last_week").toString();
                String this_month = d.optString("this_month").toString();
                String last_month = d.optString("last_month").toString();
                String this_year = d.optString("this_year").toString();
                String last_year = d.optString("last_year").toString();
                String last_sync_monoverview = d.optString("last_sync_mont").toString();
                //mydb.insert(this_week, last_week, this_month, last_month, this_year, last_year, last_sync_monoverview);
            }

        } catch (Exception e) {
            exceptionToBeThrown = e;
        }
    }

    public void updateDept(){

        //mydb.deleteAll_dept();

        serverURL2 = "http://films.mecsindh.petro.pk/films/mobile/webservice/dept_wise.php";
        try {

            String FROM_DATE = from_date.getText().toString();
            String TO_DATE = to_date.getText().toString();
            String P_STATUS = "Progress_Publish";

            Content = URLEncoder.encode("from_date", "UTF-8")
                    + "=" + URLEncoder.encode(FROM_DATE, "UTF-8").replace("+","");
            Content += "&" + URLEncoder.encode("to_date", "UTF-8")
                    + "=" + URLEncoder.encode(TO_DATE, "UTF-8").replace("+","");
            Content += "&" + URLEncoder.encode("p_status", "UTF-8")
                    + "=" + URLEncoder.encode(P_STATUS, "UTF-8");

        JSONParser jParser_dept = new JSONParser();

        JSONObject json_dept = jParser_dept.GET_DATA(serverURL2, Content);

            try {
                url2 = json_dept.optJSONArray("posts");

                // looping through all posts according to the json object returned
                for (int j = 0; j < url2.length(); j++) {
                    JSONObject dept = url2.getJSONObject(j);

                    // gets the content of each tag
                    String name = dept.optString("name_dept").toString();
                    String total = dept.optString("total_dept").toString();
                    String last_sync_dept = dept.optString("last_sync_dept").toString();
                    //mydb.insert_dept(name, total, last_sync_dept);
                }

            } catch (Exception e) {
                exceptionToBeThrown = e;
            }
        }catch (UnsupportedEncodingException e) {
            exceptionToBeThrown = e;
        }
    }

    public class DownloadData_Films extends AsyncTask<Void, Void, Boolean> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            title_head.setText("System is Downloading Files");
        }

        @Override
        protected Boolean doInBackground(Void... arg0) {

            updateMonOverview();
            updateDept();
            return null;

        }

        @Override
        protected void onPostExecute(Boolean result) {
            super.onPostExecute(result);
            if (exceptionToBeThrown != null) {
                try {
                    Snackbar.make(findViewById(android.R.id.content), "I Think You Might Have Some Problem", Snackbar.LENGTH_SHORT)
                            .setActionTextColor(Color.RED)
                            .show();
                    title_head.setText("I Think You Might Have Some Problem");
                    throw exceptionToBeThrown;
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }else {
                title_head.setText("Download Complete");
                new Handler().postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        title_head.setText("Sync Films Data");
                    }
                }, 3000);
            }
        }
    }
}
