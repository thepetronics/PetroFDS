package com.thepetronics.petro.fds;

import java.util.ArrayList;

/**
 * Created by MuhammadDanyal on 7/24/2016.
 */
public class InvoiceResponseHolder {
    private ArrayList<InvoicePost> posts = new ArrayList<>();;

    @Override
    public String toString() {
        return "ResponseHolder [Post="
                + posts + "]";
    }

    public ArrayList<InvoicePost> getInvoiceEvents() {
        return posts;
    }
}
