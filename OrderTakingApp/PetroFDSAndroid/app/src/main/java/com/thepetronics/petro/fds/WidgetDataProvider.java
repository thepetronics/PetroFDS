package com.thepetronics.petro.fds;

import java.util.ArrayList;
import java.util.List;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Color;
import android.widget.RemoteViews;
import android.widget.RemoteViewsService.RemoteViewsFactory;

/**
 * Created by danyal on 4/6/2016.
 */
@SuppressLint("NewApi")
public class WidgetDataProvider implements RemoteViewsFactory {

    List mCollections = new ArrayList();
    private DBHelper mydb;
    Context mContext = null;

    public WidgetDataProvider(Context context, Intent intent) {
        mContext = context;
    }

    @Override
    public int getCount() {
        return mCollections.size();
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public RemoteViews getLoadingView() {
        return null;
    }

    @Override
    public RemoteViews getViewAt(int position) {
        RemoteViews mView = new RemoteViews(mContext.getPackageName(),
                android.R.layout.simple_list_item_1);
        mView.setTextViewText(android.R.id.text1, mCollections.get(position).toString());
        mView.setTextColor(android.R.id.text1, Color.BLACK);
        Intent Invoice = new Intent(mContext,Invoice.class);
        Invoice.putExtra("ID", position);
        mView.setOnClickFillInIntent(R.id.widgetCollectionList, Invoice);
        return mView;
    }

    @Override
    public int getViewTypeCount() {
        return 1;
    }

    @Override
    public boolean hasStableIds() {
        return true;
    }

    @Override
    public void onCreate() {
        initData();
    }

    @Override
    public void onDataSetChanged() {
        initData();
    }

    private void initData() {
        mCollections.clear();
        mydb = new DBHelper(mContext);
        Cursor rs = mydb.getAllData("view_orders");
        rs.moveToFirst();
        while (!rs.isAfterLast()) {
            mCollections.add(rs.getString(5)+" "+rs.getString(6));
            rs.moveToNext();
        }
    }

    @Override
    public void onDestroy() {

    }

}
