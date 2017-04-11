package com.thepetronics.petro.fds;

import com.google.gson.annotations.SerializedName;

/**
 * Created by MuhammadDanyal on 7/24/2016.
 */
public class NotifyPost {
    @SerializedName("status_time")
    private String status_time;
    @SerializedName("total_order")
    private String total_order;

    public NotifyPost(String status_time, String total_order) {
        this.status_time = status_time;
        this.total_order = total_order;
    }

    public String getStatus_time() {
        return status_time;
    }
    public void setStatus_time(String status_time) {
        this.status_time = status_time;
    }
    public String getTotal_order() {
        return total_order;
    }
    public void setTotal_order(String total_order) {
        this.total_order = total_order;
    }
}
