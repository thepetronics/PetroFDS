package com.thepetronics.petro.fds;

import java.util.ArrayList;
import java.util.HashMap;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.sqlite.SQLiteOpenHelper;
import android.database.sqlite.SQLiteDatabase;
import android.util.Log;

public class DBHelper extends SQLiteOpenHelper {

    public static final String DATABASE_NAME = "PetroFDS.db";

    public static final String VIEWORDER_TABLE_NAME = "view_orders";
    public static final String VIEWORDER_COLUMN_ID = "view_order_id";
    public static final String VIEWORDER_COLUMN_USER_ID = "user_id";
    public static final String VIEWORDER_COLUMN_ORDER_DETAIL_ID = "order_detail_id";
    public static final String VIEWORDER_COLUMN_STATUS = "status";
    public static final String VIEWORDER_COLUMN_STATUS_TIME = "status_time";
    public static final String VIEWORDER_COLUMN_FIRSTNAME = "firstname";
    public static final String VIEWORDER_COLUMN_LASTNAME = "lastname";
    public static final String VIEWORDER_COLUMN_ADDRESS_1 = "address_1";
    public static final String VIEWORDER_COLUMN_ADDRESS_2 = "address_2";
    public static final String VIEWORDER_COLUMN_CITY = "city";
    public static final String VIEWORDER_COLUMN_POST_CODE = "post_code";
    public static final String VIEWORDER_COLUMN_lOYALTY_POINT = "loyalty_point";
    public static final String VIEWORDER_COLUMN_ABOUT_ORDER = "about_order";
    public static final String VIEWORDER_COLUMN_PAYMENT_METHOD = "payment_method";
    public static final String VIEWORDER_COLUMN_DECLINE_REASON = "decline_reason";
    public static final String VIEWORDER_COLUMN_ORDER_TIME = "order_time";
    public static final String VIEWORDER_COLUMN_TOTAL_PRICE = "total_price";
    public static final String VIEWORDER_COLUMN_CURRENCY = "currency";
    public static final String VIEWORDER_COLUMN_ORDER_DATE = "order_date";
    public static final String VIEWORDER_COLUMN_LAST_SYNC = "last_sync";

    public static final String INVOICE_TABLE_NAME = "invoice";
    public static final String INVOICE_COLUMN_ID = "invoice_id";
    public static final String INVOICE_COLUMN_USER_ID = "user_id";
    public static final String INVOICE_COLUMN_CUSTOMER_NAME = "customer_name";
    public static final String INVOICE_COLUMN_CONTACT_NO = "contact_no";
    public static final String INVOICE_COLUMN_POST_CODE = "post_code";
    public static final String INVOICE_COLUMN_ADDRESS = "address";
    public static final String INVOICE_COLUMN_QUANTITY = "quantity";
    public static final String INVOICE_COLUMN_PRICEALL = "priceall";
    public static final String INVOICE_COLUMN_PRICE = "price";
    public static final String INVOICE_COLUMN_NAME = "name";
    public static final String INVOICE_COLUMN_CURRENCY = "currency";
    public static final String INVOICE_COLUMN_PRICE_DISCOUNT = "price_discount";
    public static final String INVOICE_COLUMN_DELIVERY_CHARGES = "delivery_charges";
    public static final String INVOICE_COLUMN_PAY_MONEY_METHOD = "pay_money_method";
    public static final String INVOICE_COLUMN_PAYMENT_METHOD = "payment_method";
    public static final String INVOICE_COLUMN_REMARKS = "remarks";
    public static final String INVOICE_COLUMN_LAST_SYNC = "last_sync";

    public static final String SALES_TABLE_NAME = "sales";
    public static final String SALES_COLUMN_ID = "sales_id";
    public static final String SALES_COLUMN_THIS_MONTH = "this_month";
    public static final String SALES_COLUMN_LAST_MONTH = "last_month";
    public static final String SALES_COLUMN_THIS_YEAR = "this_year";
    public static final String SALES_COLUMN_LAST_YEAR = "last_year";
    public static final String SALES_COLUMN_LAST_SYNC = "last_sync";

    public static final String CUSTOMER_TABLE_NAME = "customer";
    public static final String CUSTOMER_COLUMN_ID = "customer_id";
    public static final String CUSTOMER_COLUMN_FULL_NAME = "full_name";
    public static final String CUSTOMER_COLUMN_LAST_SYNC = "last_sync";

    public static final String PRODUCT_TABLE_NAME = "product";
    public static final String PRODUCT_COLUMN_ID = "customer_id";
    public static final String PRODUCT_COLUMN_NAME = "full_name";
    public static final String PRODUCT_COLUMN_LAST_SYNC = "last_sync";

    public static final String ORDERINFO_TABLE_NAME = "orderinfo";
    public static final String ORDERINFO_COLUMN_ID = "orderinfo_id";
    public static final String ORDERINFO_COLUMN_FULLNAME = "fullname";
    public static final String ORDERINFO_COLUMN_GRANDTOTAL = "grandtotal";
    public static final String ORDERINFO_COLUMN_STATUS = "status";
    public static final String ORDERINFO_COLUMN_LIFETIMESALES = "lifetimesales";
    public static final String ORDERINFO_COLUMN_AVGSALES = "avgsales";
    public static final String ORDERINFO_COLUMN_LAST_SYNC = "last_sync";

    private HashMap hp;

    public DBHelper(Context context)
    {
        super(context, DATABASE_NAME, null, 1);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        // TODO Auto-generated method stub
        db.execSQL(
                "create table " + VIEWORDER_TABLE_NAME + "" +
                        "(" + VIEWORDER_COLUMN_ID + " integer primary key autoincrement, " + VIEWORDER_COLUMN_USER_ID + " text," +
                        "" + VIEWORDER_COLUMN_ORDER_DETAIL_ID + " text," + VIEWORDER_COLUMN_STATUS + " text, " + VIEWORDER_COLUMN_STATUS_TIME + " text," +
                        "" + VIEWORDER_COLUMN_FIRSTNAME + " text," +
                        "" + VIEWORDER_COLUMN_LASTNAME + " text, " + VIEWORDER_COLUMN_ADDRESS_1 + " text, " + VIEWORDER_COLUMN_ADDRESS_2 + " text," +
                        "" + VIEWORDER_COLUMN_CITY + " text," +
                        "" + VIEWORDER_COLUMN_POST_CODE + " text," + VIEWORDER_COLUMN_lOYALTY_POINT + " text," + VIEWORDER_COLUMN_ABOUT_ORDER + " text," +
                        "" + VIEWORDER_COLUMN_PAYMENT_METHOD + " text," +
                        "" + VIEWORDER_COLUMN_DECLINE_REASON + " text," + VIEWORDER_COLUMN_ORDER_TIME + " text," + VIEWORDER_COLUMN_TOTAL_PRICE + " text," +
                        "" + VIEWORDER_COLUMN_CURRENCY + " text," + VIEWORDER_COLUMN_ORDER_DATE + " text," + VIEWORDER_COLUMN_LAST_SYNC + " text)"
        );
        db.execSQL(
                "create table " + INVOICE_TABLE_NAME + "" +
                        "(" + INVOICE_COLUMN_ID + " integer primary key autoincrement, " + INVOICE_COLUMN_USER_ID + " text," +
                        "" + INVOICE_COLUMN_CUSTOMER_NAME + " text," + INVOICE_COLUMN_CONTACT_NO + " text," + INVOICE_COLUMN_POST_CODE + " text," +
                        "" + INVOICE_COLUMN_ADDRESS + " text," +
                        "" + INVOICE_COLUMN_QUANTITY + " text," + INVOICE_COLUMN_PRICEALL + " text, " + INVOICE_COLUMN_PRICE + " text," +
                        "" + INVOICE_COLUMN_NAME + " text," +
                        "" + INVOICE_COLUMN_CURRENCY + " text, " + INVOICE_COLUMN_PRICE_DISCOUNT + " text, " + INVOICE_COLUMN_DELIVERY_CHARGES + " text, " +
                        "" + INVOICE_COLUMN_PAY_MONEY_METHOD + " text," + INVOICE_COLUMN_PAYMENT_METHOD + " text, " + INVOICE_COLUMN_REMARKS + " text, " + INVOICE_COLUMN_LAST_SYNC + " text)"
        );
        db.execSQL(
                "create table " + SALES_TABLE_NAME + "" +
                        "(" + SALES_COLUMN_ID + " integer primary key autoincrement, " + SALES_COLUMN_THIS_MONTH + " text," +
                        "" + SALES_COLUMN_LAST_MONTH + " text, " + SALES_COLUMN_THIS_YEAR + " text, " + SALES_COLUMN_LAST_YEAR + " text, " +
                        "" + SALES_COLUMN_LAST_SYNC + " text)"
        );
        db.execSQL(
                "create table " + CUSTOMER_TABLE_NAME + "" +
                        "(" + CUSTOMER_COLUMN_ID + " integer primary key autoincrement, " + CUSTOMER_COLUMN_FULL_NAME + " text, " +
                        "" + CUSTOMER_COLUMN_LAST_SYNC + " text)"
        );
        db.execSQL(
                "create table " + PRODUCT_TABLE_NAME + "" +
                        "(" + PRODUCT_COLUMN_ID + " integer primary key autoincrement, " + PRODUCT_COLUMN_NAME + " text, " +
                        "" + PRODUCT_COLUMN_LAST_SYNC + " text)"
        );
        db.execSQL(
                "create table " + ORDERINFO_TABLE_NAME + "" +
                        "(" + ORDERINFO_COLUMN_ID + " integer primary key autoincrement, " + ORDERINFO_COLUMN_FULLNAME + " text," +
                        "" + ORDERINFO_COLUMN_GRANDTOTAL + " text," + ORDERINFO_COLUMN_STATUS + " text, " + ORDERINFO_COLUMN_LIFETIMESALES + " text," +
                        "" + ORDERINFO_COLUMN_AVGSALES + " text, " + ORDERINFO_COLUMN_LAST_SYNC + " text)"
        );
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // TODO Auto-generated method stub
        db.execSQL("DROP TABLE IF EXISTS "+ VIEWORDER_TABLE_NAME);
        db.execSQL("DROP TABLE IF EXISTS "+ INVOICE_TABLE_NAME);
        db.execSQL("DROP TABLE IF EXISTS "+ SALES_TABLE_NAME);
        db.execSQL("DROP TABLE IF EXISTS "+ CUSTOMER_TABLE_NAME);
        db.execSQL("DROP TABLE IF EXISTS "+ PRODUCT_TABLE_NAME);
        db.execSQL("DROP TABLE IF EXISTS "+ ORDERINFO_TABLE_NAME);
        onCreate(db);
    }

    public boolean insert(String user_id, String order_detail_id, String status, String status_time, String firstname, String lastname, String address_1,
                          String address_2, String city, String post_code, String loyalty_point, String about_order, String payment_method, String decline_reason,
                          String order_time, String total_price, String currency, String order_date, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(VIEWORDER_COLUMN_USER_ID, user_id);
        contentValues.put(VIEWORDER_COLUMN_ORDER_DETAIL_ID, order_detail_id);
        contentValues.put(VIEWORDER_COLUMN_STATUS, status);
        contentValues.put(VIEWORDER_COLUMN_STATUS_TIME, status_time);
        contentValues.put(VIEWORDER_COLUMN_FIRSTNAME, firstname);
        contentValues.put(VIEWORDER_COLUMN_LASTNAME, lastname);
        contentValues.put(VIEWORDER_COLUMN_ADDRESS_1, address_1);
        contentValues.put(VIEWORDER_COLUMN_ADDRESS_2, address_2);
        contentValues.put(VIEWORDER_COLUMN_CITY, city);
        contentValues.put(VIEWORDER_COLUMN_POST_CODE, post_code);
        contentValues.put(VIEWORDER_COLUMN_lOYALTY_POINT, loyalty_point);
        contentValues.put(VIEWORDER_COLUMN_ABOUT_ORDER, about_order);
        contentValues.put(VIEWORDER_COLUMN_PAYMENT_METHOD, payment_method);
        contentValues.put(VIEWORDER_COLUMN_DECLINE_REASON, decline_reason);
        contentValues.put(VIEWORDER_COLUMN_ORDER_TIME, order_time);
        contentValues.put(VIEWORDER_COLUMN_TOTAL_PRICE, total_price);
        contentValues.put(VIEWORDER_COLUMN_CURRENCY, currency);
        contentValues.put(VIEWORDER_COLUMN_ORDER_DATE, order_date);
        contentValues.put(VIEWORDER_COLUMN_LAST_SYNC, last_sync);
        db.insert(VIEWORDER_TABLE_NAME, null, contentValues);
        return true;
    }


    public boolean insert_invoice(String user_id, String customer_name, String contact_no, String post_code, String address, String quantity, String priceall, String price, String name, String currency,
                                  String price_discount, String delivery_charges, String pay_money_method, String payment_method, String remarks, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(INVOICE_COLUMN_USER_ID, user_id);
        contentValues.put(INVOICE_COLUMN_CUSTOMER_NAME, customer_name);
        contentValues.put(INVOICE_COLUMN_CONTACT_NO, contact_no);
        contentValues.put(INVOICE_COLUMN_POST_CODE, post_code);
        contentValues.put(INVOICE_COLUMN_ADDRESS, address);
        contentValues.put(INVOICE_COLUMN_QUANTITY, quantity);
        contentValues.put(INVOICE_COLUMN_PRICEALL, priceall);
        contentValues.put(INVOICE_COLUMN_PRICE, price);
        contentValues.put(INVOICE_COLUMN_NAME, name);
        contentValues.put(INVOICE_COLUMN_CURRENCY, currency);
        contentValues.put(INVOICE_COLUMN_PRICE_DISCOUNT, price_discount);
        contentValues.put(INVOICE_COLUMN_DELIVERY_CHARGES, delivery_charges);
        contentValues.put(INVOICE_COLUMN_PAY_MONEY_METHOD, pay_money_method);
        contentValues.put(INVOICE_COLUMN_PAYMENT_METHOD, payment_method);
        contentValues.put(INVOICE_COLUMN_REMARKS, remarks);
        contentValues.put(INVOICE_COLUMN_LAST_SYNC, last_sync);
        db.insert(INVOICE_TABLE_NAME, null, contentValues);
        return true;
    }

    public boolean insert_sales(String this_month, String last_month, String this_year, String last_year, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(SALES_COLUMN_THIS_MONTH, this_month);
        contentValues.put(SALES_COLUMN_LAST_MONTH, last_month);
        contentValues.put(SALES_COLUMN_THIS_YEAR, this_year);
        contentValues.put(SALES_COLUMN_LAST_YEAR, last_year);
        contentValues.put(SALES_COLUMN_LAST_SYNC, last_sync);
        db.insert(SALES_TABLE_NAME, null, contentValues);
        return true;
    }

    public boolean insert_customer(String full_name, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(CUSTOMER_COLUMN_FULL_NAME, full_name);
        contentValues.put(CUSTOMER_COLUMN_LAST_SYNC, last_sync);
        db.insert(CUSTOMER_TABLE_NAME, null, contentValues);
        return true;
    }
    public boolean insert_pr(String name, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(PRODUCT_COLUMN_NAME, name);
        contentValues.put(PRODUCT_COLUMN_LAST_SYNC, last_sync);
        db.insert(PRODUCT_TABLE_NAME, null, contentValues);
        return true;
    }
    public boolean insert_orderinfo(String fullname, String grandtotal, String status, String lifetimesales, String avgsales, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(ORDERINFO_COLUMN_FULLNAME, fullname);
        contentValues.put(ORDERINFO_COLUMN_GRANDTOTAL, grandtotal);
        contentValues.put(ORDERINFO_COLUMN_STATUS, status);
        contentValues.put(ORDERINFO_COLUMN_LIFETIMESALES, lifetimesales);
        contentValues.put(ORDERINFO_COLUMN_AVGSALES, avgsales);
        contentValues.put(ORDERINFO_COLUMN_LAST_SYNC, last_sync);
        db.insert(ORDERINFO_TABLE_NAME, null, contentValues);
        return true;
    }

    public Cursor getData(String id,String tablename){
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery( "select * from "+tablename+" where order_detail_id="+id+"", null );
        return res;
    }

    public Cursor getInvoiceData(int id,String tablename){
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery( "select * from "+tablename+" where id="+id+"", null );
        return res;
    }

    public Cursor getAllData(String tablename){
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery( "select * from "+tablename+"", null );
        return res;
    }

    public Cursor getAllInvoiceData(String tablename){
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery( "select * from "+tablename+"", null );
        return res;
    }

    public int AllRaw(String date1,String date2){
        SQLiteDatabase db = this.getReadableDatabase();
        String Qry = "SELECT COUNT(view_order_id) FROM view_orders WHERE "+VIEWORDER_COLUMN_ORDER_DATE+" BETWEEN '"+date1+"' AND '"+date2+"'";
        Cursor res =  db.rawQuery(Qry, null );
        res.moveToFirst();
        int count= res.getInt(0);
        res.close();
        Log.d("DBHelper",String.valueOf(count));
        return count;
    }

    public float SUMQuery(String Query){
        SQLiteDatabase db = this.getReadableDatabase();
        String Qry = Query;
        Cursor res =  db.rawQuery(Qry, null );
        res.moveToFirst();
        float count= res.getFloat(0);
        res.close();
        Log.d("LifeTimeSales",String.valueOf(count));
        return count;
    }

    public int getTotalRows(){
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery("select COUNT(*) from view_orders", null);
        res.moveToFirst();
        int count= res.getInt(0);
        res.close();
        Log.d("DBHelper",String.valueOf(count));
        return count;
    }

    public int numberOfRows(){
        SQLiteDatabase db = this.getReadableDatabase();
        int numRows = (int) DatabaseUtils.queryNumEntries(db, VIEWORDER_TABLE_NAME);
        return numRows;
    }

    public int numberOfRowsInvoice(){
        SQLiteDatabase db = this.getReadableDatabase();
        int numRows = (int) DatabaseUtils.queryNumEntries(db, INVOICE_TABLE_NAME);
        return numRows;
    }

    public boolean update (Integer id, String user_id, String order_detail_id, String status, String status_time, String firstname, String lastname, String address_1,
                           String address_2, String city, String post_code, String loyalty_point, String about_order, String payment_method, String decline_reason,
                           String order_time, String total_price, String currency, String order_date, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(VIEWORDER_COLUMN_USER_ID, user_id);
        contentValues.put(VIEWORDER_COLUMN_ORDER_DETAIL_ID, order_detail_id);
        contentValues.put(VIEWORDER_COLUMN_STATUS, status);
        contentValues.put(VIEWORDER_COLUMN_STATUS_TIME, status_time);
        contentValues.put(VIEWORDER_COLUMN_FIRSTNAME, firstname);
        contentValues.put(VIEWORDER_COLUMN_LASTNAME, lastname);
        contentValues.put(VIEWORDER_COLUMN_ADDRESS_1, address_1);
        contentValues.put(VIEWORDER_COLUMN_ADDRESS_2, address_2);
        contentValues.put(VIEWORDER_COLUMN_CITY, city);
        contentValues.put(VIEWORDER_COLUMN_POST_CODE, post_code);
        contentValues.put(VIEWORDER_COLUMN_lOYALTY_POINT, loyalty_point);
        contentValues.put(VIEWORDER_COLUMN_ABOUT_ORDER, about_order);
        contentValues.put(VIEWORDER_COLUMN_PAYMENT_METHOD, payment_method);
        contentValues.put(VIEWORDER_COLUMN_DECLINE_REASON, decline_reason);
        contentValues.put(VIEWORDER_COLUMN_ORDER_TIME, order_time);
        contentValues.put(VIEWORDER_COLUMN_TOTAL_PRICE, total_price);
        contentValues.put(VIEWORDER_COLUMN_CURRENCY, currency);
        contentValues.put(VIEWORDER_COLUMN_ORDER_DATE, order_date);
        contentValues.put(VIEWORDER_COLUMN_LAST_SYNC, last_sync);
        db.update(VIEWORDER_TABLE_NAME, contentValues, "id = ? ", new String[] { Integer.toString(id) } );
        return true;
    }

    public boolean update_invoice (Integer id, String user_id, String quantity, String priceall, String price, String name, String currency,
                                   String price_discount, String delivery_charges, String payment_method, String last_sync)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        ContentValues contentValues = new ContentValues();
        contentValues.put(INVOICE_COLUMN_USER_ID, user_id);
        contentValues.put(INVOICE_COLUMN_QUANTITY, quantity);
        contentValues.put(INVOICE_COLUMN_PRICEALL, priceall);
        contentValues.put(INVOICE_COLUMN_PRICE, price);
        contentValues.put(INVOICE_COLUMN_NAME, name);
        contentValues.put(INVOICE_COLUMN_CURRENCY, currency);
        contentValues.put(INVOICE_COLUMN_PRICE_DISCOUNT, price_discount);
        contentValues.put(INVOICE_COLUMN_DELIVERY_CHARGES, delivery_charges);
        contentValues.put(INVOICE_COLUMN_PAYMENT_METHOD, payment_method);
        contentValues.put(INVOICE_COLUMN_LAST_SYNC, last_sync);
        db.update(INVOICE_TABLE_NAME, contentValues, "id = ? ", new String[] { Integer.toString(id) } );
        return true;
    }

    public Integer delete (Integer id)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        return db.delete(VIEWORDER_TABLE_NAME,
                "id = ? ",
                new String[] { Integer.toString(id) });
    }

    public Integer deleteInvoice (Integer id)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        return db.delete(INVOICE_TABLE_NAME,
                "id = ? ",
                new String[] { Integer.toString(id) });
    }

    public Integer deleteAll (String tablename)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        return db.delete(tablename,null,null);
    }

    public Integer deleteAllInvoice (String tablename)
    {
        SQLiteDatabase db = this.getWritableDatabase();
        return db.delete(tablename,null,null);
    }

    public Cursor Query(String Qry){
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery(Qry, null);
        return res;
    }

    public ArrayList<String> getAll()
    {
        ArrayList<String> array_list = new ArrayList<String>();

        //hp = new HashMap();
        SQLiteDatabase db = this.getReadableDatabase();
        Cursor res =  db.rawQuery( "select * from "+VIEWORDER_TABLE_NAME, null );
        res.moveToFirst();

        while(res.isAfterLast() == false){
            array_list.add(res.getString(res.getColumnIndex(VIEWORDER_COLUMN_FIRSTNAME)));
            res.moveToNext();
        }
        return array_list;
    }
}