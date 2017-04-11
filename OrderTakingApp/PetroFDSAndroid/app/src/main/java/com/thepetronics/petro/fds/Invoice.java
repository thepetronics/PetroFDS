package com.thepetronics.petro.fds;

import android.app.PendingIntent;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.database.Cursor;
import android.graphics.Color;
import android.hardware.usb.UsbDevice;
import android.hardware.usb.UsbDeviceConnection;
import android.hardware.usb.UsbEndpoint;
import android.hardware.usb.UsbInterface;
import android.hardware.usb.UsbManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.CardView;
import android.text.Html;
import android.util.Log;
import android.view.Gravity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import com.google.gson.Gson;

import java.io.Reader;
import java.io.UnsupportedEncodingException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;

public class Invoice extends AppCompatActivity implements View.OnClickListener {

    SessionManager session;
    HashMap<String, String> user;
    private TextView btnSend = null;
    private TextView Total = null;
    private TextView DType = null;
    private TextView PaymentMethod = null;
    private TextView Deliv_Charge = null;
    private TextView Pr_Discount = null;
    private TextView Total_ALL = null;
    TextView Custm_name, add_full, custm_contact, custm_postcode;
    String ID, Symb, Symb_Print, APIKEY_URL;
    private DBHelper mydb;
    PendingIntent mPermissionIntent;
    UsbDevice device;
    UsbManager manager;
    UsbEndpoint ep;
    UsbInterface usbIf;
    UsbDeviceConnection conn;
    byte[] send;
    private static final String ACTION_USB_PERMISSION = "com.usb.USB_PERMISSION";
    TableLayout table;
    private CardView login_card;
    int WRPCNT;
    String CustomerName="";
    String ContactNo="";
    String PostCode="";
    String Address="";
    String Name="";
    String Quantity="";
    String Totl="";
    String PayBy="";
    String DeliveryType="";
    String DeliveryCharges="";
    String Discount="";
    String TotalALL="";
    String Remarks="";
    String patternRegex;
    float Ttlpr;
    float Ttlqty;
    float TotalBefore=0;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_invoice);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        getSupportActionBar().setDisplayShowHomeEnabled(true);
        Bundle extras = getIntent().getExtras();
        if (extras != null) {
            ID = extras.getString("ID");
            Log.d("ID", ID);
        }
        session = new SessionManager(this);
        user = session.getUserDetails();
        // api url
        APIKEY_URL = user.get(SessionManager.KEY_API);
        mydb = new DBHelper(this);

        ConnectivityManager cn=(ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo nf=cn.getActiveNetworkInfo();
        if(nf != null && nf.isConnected()==true ) {
            String[] separated = ID.split("\\:");
            Log.d("split",separated[1]);
            String serverURL = APIKEY_URL+"/get_invoice.php?id="+separated[1].trim();
            Log.d("serverURL",serverURL);
            mydb.deleteAllInvoice("invoice");
            new LongOperation().execute(serverURL);
        }
        table = (TableLayout) findViewById(R.id.table);
        Total = (TextView)findViewById(R.id.total);
        DType = (TextView)findViewById(R.id.d_type);
        PaymentMethod = (TextView)findViewById(R.id.payment_method);
        Deliv_Charge = (TextView)findViewById(R.id.delivery_charge);
        Pr_Discount = (TextView)findViewById(R.id.price_discount);
        Total_ALL = (TextView)findViewById(R.id.total_all);
        Custm_name = (TextView)findViewById(R.id.custm_name);
        add_full = (TextView)findViewById(R.id.add_full);
        custm_contact = (TextView)findViewById(R.id.custm_contact);
        custm_postcode = (TextView)findViewById(R.id.custm_postcode);
        login_card = (CardView)findViewById(R.id.login_card);

        btnSend = (TextView)findViewById(R.id.btnSend);

        btnSend.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View arg0) {
                checkInfo();

            }
        });

        btnSend.setOnTouchListener(new View.OnTouchListener() {
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
        getMenuInflater().inflate(R.menu.menu_invoice, menu);
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

    private class LongOperation extends AsyncTask<String, Void, Void> {
        protected void onPreExecute() {

        }

        // Call after onPreExecute method
        protected Void doInBackground(String... urls) {
            Gson Json = new Gson();
            Reader reader = API.getData(urls[0]);
            InvoiceResponseHolder RH = Json.fromJson(reader, InvoiceResponseHolder.class);
            if(RH.getInvoiceEvents() != null){
                mydb.deleteAll("view_orders");
            }
            for(InvoicePost Data: RH.getInvoiceEvents()){
                String user_id = Data.getUser_id();
                String customer_name = Data.getCustomer_name();
                String contact_no = Data.getContact_no();
                String post_code = Data.getPost_code();
                String address = Data.getInvAddress();
                String quantity = Data.getQuantity();
                String price_all = Data.getPrice_all();
                String price = Data.getPrice();
                String name = Data.getInvName();
                String currency = Data.getCurrency();
                String price_discount = Data.getPrice_discount();
                String delivery_charges = Data.getDelivery_charges();
                String pay_money_method = Data.getPay_money_method();
                String payment_method = Data.getPayment_method();
                String remarks = Data.getRemarks();
                String last_sync = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());

                mydb.insert_invoice(user_id, customer_name, contact_no, post_code, address, quantity, price_all, price, name, currency, price_discount, delivery_charges, pay_money_method, payment_method, remarks, last_sync);
            }
            return null;
        }
        protected void onPostExecute(Void unused) {
            TableRow start = new TableRow(Invoice.this);
            start.setBackgroundColor(Color.parseColor("#92C94A"));

            TextView stv1 = new TextView(Invoice.this);
            stv1.setTextColor(Color.WHITE);
            stv1.setPadding(10, 20, 10, 20);
            stv1.setTextSize(14);

            LinearLayout sl2 = new LinearLayout(Invoice.this);

            TextView stv3 = new TextView(Invoice.this);
            stv3.setTextColor(Color.WHITE);
            stv3.setPadding(10, 20, 10, 20);
            stv3.setTextSize(14);

            LinearLayout sl3 = new LinearLayout(Invoice.this);

            TextView stv4 = new TextView(Invoice.this);
            stv4.setTextColor(Color.WHITE);
            stv4.setPadding(10, 20, 10, 20);
            stv4.setTextSize(14);

            stv1.setText("Product Name: ");
            stv3.setText("Quantity: ");
            stv4.setText("Total: ");
            start.addView(stv1);
            start.addView(sl2);
            start.addView(stv3);
            start.addView(sl3);
            start.addView(stv4);
            table.addView(start,0);

            Cursor rs = mydb.getAllData("invoice");
            rs.moveToFirst();
            int c=1;
            while (!rs.isAfterLast()) {
                Log.d("Name", String.valueOf(c));

                //Customer Details
                Custm_name.setText("Name: "+rs.getString(2));
                add_full.setText("Address: "+rs.getString(5));
                custm_contact.setText("Contact No: "+rs.getString(3));
                custm_postcode.setText("Postcode: "+rs.getString(4));
                DType.setText("Delivery Type: "+rs.getString(rs.getColumnIndex("payment_method")));

                Symb = String.valueOf(Html.fromHtml(rs.getString(10)));

                Ttlpr += Float.parseFloat(rs.getString(8));
                Ttlqty = Float.parseFloat(rs.getString(6));
                TotalBefore += (Ttlpr)*(Ttlqty);
                TableRow row = new TableRow(Invoice.this);
                TextView name = new TextView(Invoice.this);
                name.setPadding(10, 10, 10, 10);
                LinearLayout l2=new LinearLayout(Invoice.this);
                TextView qty = new TextView(Invoice.this);
                qty.setPadding(10, 10, 10, 10);
                qty.setGravity(Gravity.CENTER);
                LinearLayout l3=new LinearLayout(Invoice.this);
                TextView total = new TextView(Invoice.this);
                total.setPadding(10, 10, 10, 10);
                LinearLayout l4=new LinearLayout(Invoice.this);
                name.setText(Html.fromHtml(rs.getString(9)));
                qty.setText(rs.getString(6));
                total.setText(Symb + "" + rs.getString(8));
                Total.setText("Total: "+Symb+String.valueOf(String.format("%.2f", Ttlpr)));
                PaymentMethod.setText("Payment Method: "+rs.getString(rs.getColumnIndex("pay_money_method")));
                if(rs.getString(14).equals("Home Delivery")) {
                    Deliv_Charge.setText("Delivery Charges: " + Symb + "" + rs.getString(12));
                }else if(rs.getString(14).equals("Collect From Store")){
                    Deliv_Charge.setText("Delivery Charges: " + Symb + "0");
                }
                if(!rs.getString(11).equals("")){
                    Pr_Discount.setText("Price Discount: "+ rs.getString(11)+"%");
                }else{
                    Pr_Discount.setText("");
                }
                Total_ALL.setText("Grand Total: "+Symb + "" + rs.getString(7));
                row.addView(name);
                row.addView(l2);
                row.addView(qty);
                row.addView(l3);
                row.addView(total);
                row.addView(l4);
                table.addView(row, c);
                c++;
                rs.moveToNext();
            }
        }
    }
    private void checkInfo() {
        manager = (UsbManager) getSystemService(Context.USB_SERVICE);
		/*
		 * this block required if you need to communicate to USB devices it's
		 * take permission to device
		 * if you want than you can set this to which device you want to communicate
		 */
        // ------------------------------------------------------------------
        mPermissionIntent = PendingIntent.getBroadcast(this, 0, new Intent(
                ACTION_USB_PERMISSION), 0);
        IntentFilter filter = new IntentFilter(ACTION_USB_PERMISSION);
        registerReceiver(mUsbReceiver, filter);
        // -------------------------------------------------------------------
        HashMap<String , UsbDevice> deviceList = manager.getDeviceList();
        Iterator<UsbDevice> deviceIterator = deviceList.values().iterator();
        String i = "";
        while (deviceIterator.hasNext()) {
            device = deviceIterator.next();
            manager.requestPermission(device, mPermissionIntent);
            i += "\n" + "DeviceID: " + device.getDeviceId() + "\n"
                    + "DeviceName: " + device.getDeviceName() + "\n"
                    + "DeviceClass: " + device.getDeviceClass() + " - "
                    + "DeviceSubClass: " + device.getDeviceSubclass() + "\n"
                    + "VendorID: " + device.getVendorId() + "\n"
                    + "ProductID: " + device.getProductId() + "\n";
        }
        Log.d("Device Information", i);
    }

    private final BroadcastReceiver mUsbReceiver = new BroadcastReceiver() {

        public void onReceive(Context context, Intent intent) {
            String action = intent.getAction();
            if (ACTION_USB_PERMISSION.equals(action)) {
                synchronized (this) {
                    UsbDevice device = (UsbDevice) intent
                            .getParcelableExtra(UsbManager.EXTRA_DEVICE);
                    if (intent.getBooleanExtra(
                            UsbManager.EXTRA_PERMISSION_GRANTED, false)) {
                        if (device != null) {
                            int n=0;
                            Cursor rs1 = mydb.getAllData("invoice");
                            rs1.moveToFirst();
                            while (!rs1.isAfterLast()) {
                                Symb_Print = String.valueOf(Html.fromHtml(rs1.getString(10)));
                                CustomerName = rs1.getString(2);
                                ContactNo = rs1.getString(3);
                                PostCode = rs1.getString(4);
                                Address = rs1.getString(5);
                                WRPCNT = countLines(Wrap(rs1.getString(9)));
                                Log.d("WRPCNT", String.valueOf(WRPCNT));
                                StringBuilder NN = new StringBuilder();
                                for(int l=1; l<=WRPCNT; l++){
                                    NN.append(" \n");
                                }
                                Log.d("NL", NN.toString());
                                patternRegex = "(?i)<br */?>";
                                //Name += Wrap(rs1.getString(9))+" \n";
                                Name += Wrap(rs1.getString(9)).replaceAll(patternRegex,"\n")+" \n";
                                Quantity += rs1.getString(6)+NN.toString();
                                Totl += rs1.getString(8)+NN.toString();
                                PayBy = rs1.getString(13);
                                DeliveryType = rs1.getString(14);
                                if(rs1.getString(14).equals("Home Delivery")) {
                                    DeliveryCharges = rs1.getString(12);
                                }else if(rs1.getString(14).equals("Collect From Store")){
                                    DeliveryCharges = "0";
                                }
                                if(!rs1.getString(11).equals("")){
                                    Discount = rs1.getString(11)+"%";
                                }else{
                                    Discount = "";
                                }
                                TotalALL = rs1.getString(7);
                                Remarks = rs1.getString(15);
                                n++;
                                rs1.moveToNext();
                            }
                            String[] SplitID = ID.split(":");
                            SimpleDateFormat sdf = new SimpleDateFormat("yyyy/MM/dd hh:mm aaa");
                            String currentDateandTime = sdf.format(new Date());
                            Board board = new Board(60);
                            Block HEADER = new Block(board,60,10,"  PetroFDS \n  Order Receipt#"+SplitID[1].trim()+" \n  Contact Us At: 01234 567 890 \n  Date: "+currentDateandTime+" \n\n" +
                                    "  Customer Name:"+CustomerName+" \n  Contact No:"+ContactNo+" \n  PostCode:"+PostCode+" \n  Address:"+Address+" \n  Delivery Type:"+DeliveryType).allowGrid(false);
                            Block NameBlock = new Block(board,25,500,"  Product Name\n"+Name+" \n  Payment Method: "+PayBy+" \n  Total: "+String.valueOf(String.format("%.2f", Ttlpr))+" \n  Delivery Charges: "+DeliveryCharges+" \n  Price Discount: "+Discount+" \n  GrandTotal: "+TotalALL+" \n  Remarks: "+Remarks).allowGrid(false);
                            HEADER.setBelowBlock(NameBlock);
                            Block QtyBlock = new Block(board,15,500,"Quantity\n"+Quantity).allowGrid(false);
                            NameBlock.setRightBlock(QtyBlock);
                            Block TotalBlock = new Block(board,20,500,"Total\n"+Totl).allowGrid(false);
                            QtyBlock.setRightBlock(TotalBlock);
                            String receiptString = board.setInitialBlock(HEADER).build().getPreview();
                            sendMsg(receiptString, "GBK", device);
                            cutPaper(device, n);
                            Intent ViewOrders = new Intent(Invoice.this, ViewOrders.class);
                            startActivity(ViewOrders);
                            finish();
                        }
                    } else {
                        Log.d("ERROR", "permission denied for device " + device);
                    }
                }
            }
        }
    };
    public synchronized void sendMsg(String msg, String charset, UsbDevice dev)
    {
        if (msg.length() == 0) {
            return;
        }
        byte[] send;
        try
        {
            send = msg.getBytes(charset);
        }
        catch (UnsupportedEncodingException e)
        {
            send = msg.getBytes();
        }
        sendByte(send, dev);
        sendByte(new byte[] { 13, 10 }, dev);
    }
    public void sendByte(byte[] bits, UsbDevice dev)
    {
        if (bits == null) {
            return;
        }
        if ((this.ep != null) && (this.usbIf != null) && (this.conn != null))
        {
            this.conn.bulkTransfer(this.ep, bits, bits.length, 0);
        }
        else
        {
            if (this.conn == null) {
                this.conn = this.manager.openDevice(dev);
            }
            if (dev.getInterfaceCount() == 0) {
                return;
            }
            this.usbIf = dev.getInterface(0);
            if (this.usbIf.getEndpointCount() == 0) {
                return;
            }
            for (int i = 0; i < this.usbIf.getEndpointCount(); i++) {
                if ((this.usbIf.getEndpoint(i).getType() == 2) &&
                        (this.usbIf.getEndpoint(i).getDirection() != 128)) {
                    this.ep = this.usbIf.getEndpoint(i);
                }
            }
            if (this.conn.claimInterface(this.usbIf, true)) {
                this.conn.bulkTransfer(this.ep, bits, bits.length, 0);
            }
        }
    }
    public synchronized void cutPaper(UsbDevice dev, int n)
    {
        byte[] bits = new byte[4];
        bits[0] = 29;
        bits[1] = 86;
        bits[2] = 66;
        bits[3] = ((byte)n);
        sendByte(bits, dev);
    }
    public String Wrap(String text){
        String s = text;

        StringBuilder sb = new StringBuilder(s);

        int i = 0;
        while ((i = sb.indexOf(" ", i + 14)) != -1) {
            sb.replace(i, i + 1, "\n  ");
        }
        return "  "+sb.toString();
    }
    private static int countLines(String str){
        String[] lines = str.split("\r\n|\r|\n");
        return  lines.length;
    }
}
