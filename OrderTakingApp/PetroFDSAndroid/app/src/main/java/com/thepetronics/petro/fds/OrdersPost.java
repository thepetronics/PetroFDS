package com.thepetronics.petro.fds;

import com.google.gson.annotations.SerializedName;

/**
 * Created by MuhammadDanyal on 7/24/2016.
 */
public class OrdersPost {
    @SerializedName("user_id")
    private String user_id;
    @SerializedName("order_detail_id")
    private String order_detail_id;
    @SerializedName("status")
    private String status;
    @SerializedName("status_time")
    private String status_time;
    @SerializedName("firstname")
    private String firstname;
    @SerializedName("lastname")
    private String lastname;
    @SerializedName("add_1")
    private String add_1;
    @SerializedName("add_2")
    private String add_2;
    @SerializedName("city")
    private String city;
    @SerializedName("post_code")
    private String post_code;
    @SerializedName("loyalty_point")
    private String loyalty_point;
    @SerializedName("about_order")
    private String about_order;
    @SerializedName("payment_method")
    private String payment_method;
    @SerializedName("decline_reason")
    private String decline_reason;
    @SerializedName("order_time")
    private String order_time;
    @SerializedName("total_price")
    private String total_price;
    @SerializedName("currency")
    private String currency;
    @SerializedName("date_order")
    private String date_order;

    public OrdersPost(String user_id, String order_detail_id, String status, String status_time, String firstname, String lastname,
                      String add_1, String add_2, String city, String post_code, String loyalty_point, String about_order,
                      String payment_method, String decline_reason, String order_time, String total_price, String currency,
                      String date_order) {
        this.user_id = user_id;
        this.order_detail_id = order_detail_id;
        this.status = status;
        this.status_time = status_time;
        this.firstname = firstname;
        this.lastname = lastname;
        this.add_1 = add_1;
        this.add_2 = add_2;
        this.city = city;
        this.post_code = post_code;
        this.loyalty_point = loyalty_point;
        this.about_order = about_order;
        this.payment_method = payment_method;
        this.decline_reason = decline_reason;
        this.order_time = order_time;
        this.total_price = total_price;
        this.currency = currency;
        this.date_order = date_order;
    }

    public String getUser_id() {
        return user_id;
    }
    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }
    public String getOrder_detail_id() {
        return order_detail_id;
    }
    public void setOrder_detail_id(String order_detail_id) {
        this.order_detail_id = order_detail_id;
    }
    public String getStatus() {
        return status;
    }
    public void setStatus(String status) {
        this.status = status;
    }
    public String getStatus_time() {
        return status_time;
    }
    public void setStatus_time(String status_time) {
        this.status_time = status_time;
    }
    public String getFirstname() {
        return firstname;
    }
    public void setFirstname(String firstname) {
        this.firstname = firstname;
    }
    public String getLastname() {
        return lastname;
    }
    public void setLastname(String lastname) {
        this.lastname = lastname;
    }
    public String getAdd_1() {
        return add_1;
    }
    public void setAdd_1(String add_1) {
        this.add_1 = add_1;
    }
    public String getAdd_2() {
        return add_2;
    }
    public void setAdd_2(String add_2) {
        this.add_2 = add_2;
    }
    public String getCity() {
        return city;
    }
    public void setCity(String city) {
        this.city = city;
    }
    public String getPost_code() {
        return post_code;
    }
    public void setPost_code(String post_code) {
        this.post_code = post_code;
    }
    public String getLoyalty_point() {
        return loyalty_point;
    }
    public void setLoyalty_point(String loyalty_point) {
        this.loyalty_point = loyalty_point;
    }
    public String getAbout_order() {
        return about_order;
    }
    public void setAbout_order(String about_order) {
        this.about_order = about_order;
    }
    public String getPayment_method() {
        return payment_method;
    }
    public void setPayment_method(String payment_method) {
        this.payment_method = payment_method;
    }
    public String getDecline_reason() {
        return decline_reason;
    }
    public void setDecline_reason(String decline_reason) {
        this.decline_reason = decline_reason;
    }
    public String getOrder_time() {
        return order_time;
    }
    public void setOrder_time(String order_time) {
        this.order_time = order_time;
    }
    public String getTotal_price() {
        return total_price;
    }
    public void setTotal_price(String total_price) {
        this.total_price = total_price;
    }
    public String getCurrency() {
        return currency;
    }
    public void setCurrency(String currency) {
        this.currency = currency;
    }
    public String getDate_order() {
        return date_order;
    }
    public void setDate_order(String date_order) {
        this.date_order = date_order;
    }
}
