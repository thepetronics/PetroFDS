package com.thepetronics.petro.fds;

import java.util.ArrayList;

/**
 * Created by MuhammadDanyal on 7/24/2016.
 */
public class NotifyResponseHolder {
    private ArrayList<NotifyPost> posts = new ArrayList<>();;

    @Override
    public String toString() {
        return "ResponseHolder [Post="
                + posts + "]";
    }

    public ArrayList<NotifyPost> getNotifyEvents() {
        return posts;
    }
}
