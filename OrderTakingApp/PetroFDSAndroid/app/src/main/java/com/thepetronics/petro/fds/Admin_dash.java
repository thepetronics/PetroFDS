package com.thepetronics.petro.fds;

import android.database.Cursor;
import android.graphics.Color;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.text.Html;
import android.view.Menu;
import android.view.MenuItem;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import com.github.mikephil.charting.charts.PieChart;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.data.PieData;
import com.github.mikephil.charting.data.PieDataSet;
import com.github.mikephil.charting.utils.ColorTemplate;

import java.util.ArrayList;
import java.util.Currency;
import java.util.Locale;

public class Admin_dash extends AppCompatActivity  {

    private PieChart PChart;
    private PieData Data;
    private PieDataSet DataSet;
    private DBHelper mydb;
    private Typeface tf;
    TableLayout table_top5, Customer_table, Product_table;
    TextView LifeTimeSales, AverageSales;
    String CurrencySymbol;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_admin_dash);
        mydb = new DBHelper(this);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        table_top5 = (TableLayout) findViewById(R.id.table_top5);
        Customer_table = (TableLayout) findViewById(R.id.table_topC);
        Product_table = (TableLayout) findViewById(R.id.table_topP);
        LifeTimeSales = (TextView) findViewById(R.id.life_time_sales);
        AverageSales = (TextView) findViewById(R.id.avg_sales);

        PChart = (PieChart) findViewById(R.id.chart_sales);

        Cursor rs_sym = mydb.getAllData("view_orders");
        if(rs_sym.moveToFirst()) {
            rs_sym.moveToFirst();
            while (!rs_sym.isAfterLast()) {
                if (rs_sym.getString(17).equals("pounds")) {
                    Locale.setDefault(Locale.UK);
                    Currency c = Currency.getInstance("EUR");
                    CurrencySymbol = c.getSymbol();
                } else if (rs_sym.getString(17).equals("dollar")) {
                    Locale.setDefault(Locale.US);
                    Currency c = Currency.getInstance("USD");
                    CurrencySymbol = c.getSymbol();
                }
                rs_sym.moveToNext();
            }
        }
        /** Sales Chart Start **/
        PChart.setHoleColorTransparent(true);

        PChart.setHoleRadius(60f);

        PChart.setDrawCenterText(true);

        PChart.setDrawHoleEnabled(true);

        PChart.setRotationAngle(0);

        PChart.setDragDecelerationFrictionCoef(0.95f);

        tf = Typeface.createFromAsset(getAssets(), "OpenSans-Regular.ttf");

        PChart.setCenterTextTypeface(Typeface.createFromAsset(getAssets(), "OpenSans-Light.ttf"));

        PChart.setRotationEnabled(true);

        PChart.setTransparentCircleAlpha(110);

        ArrayList<Entry> yVals1 = new ArrayList<Entry>();
        Cursor Sales = mydb.getAllData("sales");
        if(Sales.moveToFirst()) {
            Sales.moveToFirst();
            while (!Sales.isAfterLast()) {
                yVals1.add(new Entry(Sales.getInt(1), 0));
                yVals1.add(new Entry(Sales.getInt(2), 1));
                yVals1.add(new Entry(Sales.getInt(3), 2));
                yVals1.add(new Entry(Sales.getInt(4), 3));
                Sales.moveToNext();
            }
        }
        PChart.setCenterText("YEAR AND MONTH REVIEW");

        ArrayList<String> xVals = new ArrayList<String>();
        xVals.add("This Month");
        xVals.add("Last Month");
        xVals.add("This Year");
        xVals.add("Last Year");

        ArrayList<Integer> colors = new ArrayList<Integer>();
        for (int c : ColorTemplate.VORDIPLOM_COLORS)
            colors.add(c);

        for (int c : ColorTemplate.JOYFUL_COLORS)
            colors.add(c);

        for (int c : ColorTemplate.COLORFUL_COLORS)
            colors.add(c);

        for (int c : ColorTemplate.LIBERTY_COLORS)
            colors.add(c);

        for (int c : ColorTemplate.PASTEL_COLORS)
            colors.add(c);

        colors.add(ColorTemplate.getHoloBlue());


        DataSet = new PieDataSet(yVals1, "Legends");
        DataSet.setSliceSpace(3f);
        DataSet.setColors(colors);



        Data = new PieData(xVals, DataSet);
        //Data.setValueFormatter(new PercentFormatter());
        Data.setValueTextSize(11f);
        Data.setValueTypeface(tf);
        PChart.setData(Data);
        PChart.setDescription("Sales Graph");
        PChart.setDrawSliceText(true);
        PChart.animateXY(2000, 2000);
        PChart.invalidate();
        /** Sales Chart End **/

        /** Top Customer Start **/
        TableRow start_customer = new TableRow(Admin_dash.this);
        start_customer.setBackgroundColor(Color.parseColor("#92C94A"));
        start_customer.setLayoutParams(new ViewGroup.LayoutParams(
                ViewGroup.LayoutParams.MATCH_PARENT,
                ViewGroup.LayoutParams.WRAP_CONTENT));

        TextView customer_name = new TextView(Admin_dash.this);
        customer_name.setTextColor(Color.WHITE);
        customer_name.setPadding(10, 0, 0, 0);
        customer_name.setTextSize(15);

        customer_name.setText("Customer Name: ");
        start_customer.addView(customer_name);
        Customer_table.addView(start_customer, 0);

        Cursor Customer_query = mydb.getAllData("customer");
        if(Customer_query.moveToFirst()) {
            Customer_query.moveToFirst();
            int d = 1;
            while (!Customer_query.isAfterLast()) {
                TableRow row_customer_name = new TableRow(Admin_dash.this);
                row_customer_name.setLayoutParams(new ViewGroup.LayoutParams(
                        ViewGroup.LayoutParams.MATCH_PARENT,
                        ViewGroup.LayoutParams.WRAP_CONTENT));
                TextView name_customer = new TextView(Admin_dash.this);
                name_customer.setPadding(10, 0, 0, 0);

                name_customer.setText(Customer_query.getString(1));
                row_customer_name.addView(name_customer);
                Customer_table.addView(row_customer_name, d);
                d++;
                Customer_query.moveToNext();
            }
        }
        /** Top Customer End **/

        /** Top Product Start **/
        TableRow start_pr = new TableRow(Admin_dash.this);
        start_pr.setBackgroundColor(Color.parseColor("#92C94A"));
        start_pr.setLayoutParams(new ViewGroup.LayoutParams(
                ViewGroup.LayoutParams.MATCH_PARENT,
                ViewGroup.LayoutParams.WRAP_CONTENT));

        TextView product_name = new TextView(Admin_dash.this);
        product_name.setTextColor(Color.WHITE);
        product_name.setPadding(10, 0, 0, 0);
        product_name.setTextSize(15);

        product_name.setText("Product Name: ");
        start_pr.addView(product_name);
        Product_table.addView(start_pr, 0);

        Cursor Product_query = mydb.getAllData("product");
        if(Product_query.moveToFirst()) {
            Product_query.moveToFirst();
            int e = 1;
            while (!Product_query.isAfterLast()) {
                TableRow row_pr_name = new TableRow(Admin_dash.this);
                row_pr_name.setLayoutParams(new ViewGroup.LayoutParams(
                        ViewGroup.LayoutParams.MATCH_PARENT,
                        ViewGroup.LayoutParams.WRAP_CONTENT));
                TextView name_pr = new TextView(Admin_dash.this);
                name_pr.setPadding(10, 0, 0, 0);

                name_pr.setText(Product_query.getString(1));
                row_pr_name.addView(name_pr);
                Product_table.addView(row_pr_name, e);
                e++;
                Product_query.moveToNext();
            }
        }
        /** Top Product End **/

        /** Last 5 Order Info Start **/
        TableRow start = new TableRow(Admin_dash.this);
        start.setBackgroundColor(Color.parseColor("#92C94A"));
        start.setLayoutParams(new ViewGroup.LayoutParams(
                ViewGroup.LayoutParams.MATCH_PARENT,
                ViewGroup.LayoutParams.WRAP_CONTENT));

        TextView stv1 = new TextView(Admin_dash.this);
        stv1.setTextColor(Color.WHITE);
        stv1.setPadding(30, 20, 10, 20);
        stv1.setTextSize(14);

        LinearLayout sl2 = new LinearLayout(Admin_dash.this);

        TextView stv3 = new TextView(Admin_dash.this);
        stv3.setTextColor(Color.WHITE);
        stv3.setPadding(10, 20, 10, 20);
        stv3.setTextSize(14);

        LinearLayout sl3 = new LinearLayout(Admin_dash.this);

        TextView stv4 = new TextView(Admin_dash.this);
        stv4.setTextColor(Color.WHITE);
        stv4.setPadding(10, 20, 10, 20);
        stv4.setTextSize(14);

        stv1.setText("Customer: ");
        stv3.setText("Grand Total: ");
        stv4.setText("Status: ");
        start.addView(stv1);
        start.addView(sl2);
        start.addView(stv3);
        start.addView(sl3);
        start.addView(stv4);
        table_top5.addView(start, 0);

        Cursor rs = mydb.getAllData("orderinfo");
        if(rs.moveToFirst()) {
            rs.moveToFirst();
            int c = 1;
            while (!rs.isAfterLast()) {
                LifeTimeSales.setText(Html.fromHtml(rs.getString(4)));
                TableRow row = new TableRow(Admin_dash.this);
                row.setLayoutParams(new ViewGroup.LayoutParams(
                        ViewGroup.LayoutParams.MATCH_PARENT,
                        ViewGroup.LayoutParams.WRAP_CONTENT));
                TextView name = new TextView(Admin_dash.this);
                LinearLayout l2 = new LinearLayout(Admin_dash.this);
                TextView GrTotal = new TextView(Admin_dash.this);
                GrTotal.setPadding(10, 0, 0, 0);
                LinearLayout l3 = new LinearLayout(Admin_dash.this);
                TextView status = new TextView(Admin_dash.this);
                LinearLayout l4 = new LinearLayout(Admin_dash.this);
                name.setText(rs.getString(1));
                GrTotal.setText(Html.fromHtml(rs.getString(2)));
                status.setText(rs.getString(3));
                row.addView(name);
                row.addView(l2);
                row.addView(GrTotal);
                row.addView(l3);
                row.addView(status);
                row.addView(l4);
                table_top5.addView(row, c);
                AverageSales.setText(Html.fromHtml(rs.getString(5)));
                c++;
                rs.moveToNext();
            }
        }
        /** Last 5 Order Info End **/
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_reports, menu);
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
}
