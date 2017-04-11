package com.thepetronics.petro.fds;

import android.graphics.Color;
import android.support.v7.widget.RecyclerView;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.ArrayList;

/**
 * Created by danyal on 9/7/2015.
 */
public class MyRecyclerViewAdapter extends RecyclerView
        .Adapter<MyRecyclerViewAdapter
        .DataObjectHolder> {
    private static String LOG_TAG = "MyRecyclerViewAdapter";
    private ArrayList<DataObject> mDataset;
    private static MyClickListener myClickListener;

    public static class DataObjectHolder extends RecyclerView.ViewHolder
            implements View
            .OnClickListener {
        TextView name;
        TextView id;
        TextView status;
        TextView address;
        TextView datetime;

        public DataObjectHolder(View itemView) {
            super(itemView);
            name = (TextView) itemView.findViewById(R.id.name);
            id = (TextView) itemView.findViewById(R.id.id);
            status = (TextView) itemView.findViewById(R.id.status);
            address = (TextView) itemView.findViewById(R.id.address);
            datetime = (TextView) itemView.findViewById(R.id.datetime);
            Log.i(LOG_TAG, "Adding Listener");
            itemView.setOnClickListener(this);
        }

        @Override
        public void onClick(View v) {
            myClickListener.onItemClick(getAdapterPosition(), v);
        }
    }

    public void setOnItemClickListener(MyClickListener myClickListener) {
        this.myClickListener = myClickListener;
    }

    public MyRecyclerViewAdapter(ArrayList<DataObject> myDataset) {
        mDataset = myDataset;
    }

    @Override
    public DataObjectHolder onCreateViewHolder(ViewGroup parent,
                                               int viewType) {
        View view = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.card_view_row, parent, false);

        DataObjectHolder dataObjectHolder = new DataObjectHolder(view);
        return dataObjectHolder;
    }

    @Override
    public void onBindViewHolder(DataObjectHolder holder, int position) {
        String[] data = mDataset.get(position).getmText3().split(":");
        if(data[1].trim().equals("PENDING")){
            holder.name.setBackgroundColor(Color.BLACK);
            holder.name.setText(mDataset.get(position).getmText1());
            holder.status.setTextColor(Color.BLACK);
            holder.status.setText(mDataset.get(position).getmText3());
        }else if(data[1].trim().equals("ACCEPTED")){
            holder.name.setBackgroundColor(Color.GREEN);
            holder.name.setText(mDataset.get(position).getmText1());
            holder.status.setTextColor(Color.GREEN);
            holder.status.setText(mDataset.get(position).getmText3());
        }else if(data[1].trim().equals("DELIVERED")){
            holder.name.setBackgroundColor(Color.MAGENTA);
            holder.name.setText(mDataset.get(position).getmText1());
            holder.status.setTextColor(Color.MAGENTA);
            holder.status.setText(mDataset.get(position).getmText3());
        }else if(data[1].trim().equals("DECLINE")){
            holder.name.setBackgroundColor(Color.RED);
            holder.name.setText(mDataset.get(position).getmText1());
            holder.status.setTextColor(Color.RED);
            holder.status.setText(mDataset.get(position).getmText3());
        }
        holder.id.setText(mDataset.get(position).getmText2());
        holder.address.setText(mDataset.get(position).getmText4());
        holder.datetime.setText(mDataset.get(position).getmText5());
    }

    public void addItem(DataObject dataObj, int index) {
        mDataset.add(index, dataObj);
        notifyItemInserted(index);
    }

    public void deleteItem(int index) {
        mDataset.remove(index);
        notifyItemRemoved(index);
    }

    @Override
    public int getItemCount() {
        return mDataset.size();
    }

    public void setFilter(ArrayList<DataObject> DataModels) {
        mDataset = new ArrayList<>();
        mDataset.addAll(DataModels);
        notifyDataSetChanged();
    }

    public interface MyClickListener {
        public void onItemClick(int position, View v);
    }
}
