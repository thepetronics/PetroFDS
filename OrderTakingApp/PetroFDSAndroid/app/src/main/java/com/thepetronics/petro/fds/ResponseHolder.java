package com.thepetronics.petro.fds;

import java.util.ArrayList;

/**
 * Created by MuhammadDanyal on 7/24/2016.
 */
public class ResponseHolder {
    private ArrayList<OrdersPost> posts = new ArrayList<>();

    @Override
    public String toString() {
        return "ResponseHolder [Post="
                + posts + "]";
    }

    public ArrayList<OrdersPost> getEvents() {
        return posts;
    }
}
