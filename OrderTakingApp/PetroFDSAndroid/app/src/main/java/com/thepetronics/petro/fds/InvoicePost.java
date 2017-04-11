package com.thepetronics.petro.fds;

import com.google.gson.annotations.SerializedName;

/**
 * Created by MuhammadDanyal on 7/24/2016.
 */
public class InvoicePost {
    @SerializedName("user_id")
    private String user_id;
    @SerializedName("customer_name")
    private String customer_name;
    @SerializedName("contact_no")
    private String contact_no;
    @SerializedName("post_code")
    private String post_code;
    @SerializedName("address")
    private String address;
    @SerializedName("quantity")
    private String quantity;
    @SerializedName("price_all")
    private String price_all;
    @SerializedName("price")
    private String price;
    @SerializedName("name")
    private String name;
    @SerializedName("currency")
    private String currency;
    @SerializedName("price_discount")
    private String price_discount;
    @SerializedName("delivery_charges")
    private String delivery_charges;
    @SerializedName("pay_money_method")
    private String pay_money_method;
    @SerializedName("payment_method")
    private String payment_method;
    @SerializedName("remarks")
    private String remarks;

    public InvoicePost(String user_id, String customer_name, String contact_no, String post_code, String address, String quantity,
                       String price_all, String price, String name, String currency, String price_discount, String delivery_charges,
                       String pay_money_method, String payment_method, String remarks) {
        this.user_id = user_id;
        this.customer_name = customer_name;
        this.contact_no = contact_no;
        this.post_code = post_code;
        this.address = address;
        this.quantity = quantity;
        this.price_all = price_all;
        this.price = price;
        this.name = name;
        this.currency = currency;
        this.price_discount = price_discount;
        this.delivery_charges = delivery_charges;
        this.pay_money_method = pay_money_method;
        this.payment_method = payment_method;
        this.remarks = remarks;
    }

    public String getUser_id() {
        return user_id;
    }
    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }
    public String getCustomer_name() {
        return customer_name;
    }
    public void setCustomer_name(String customer_name) {
        this.customer_name = customer_name;
    }
    public String getContact_no() {
        return contact_no;
    }
    public void setContact_no(String contact_no) {
        this.contact_no = contact_no;
    }
    public String getPost_code() {
        return post_code;
    }
    public void setPost_code(String post_code) {
        this.post_code = post_code;
    }
    public String getInvAddress() {
        return address;
    }
    public void setInvAddress(String address) {
        this.address = address;
    }
    public String getQuantity() {
        return quantity;
    }
    public void setQuantity(String quantity) {
        this.quantity = quantity;
    }
    public String getPrice_all() {
        return price_all;
    }
    public void setPrice_all(String price_all) {
        this.price_all = price_all;
    }
    public String getPrice() {
        return price;
    }
    public void setPrice(String price) {
        this.price = price;
    }
    public String getInvName() {
        return name;
    }
    public void setInvName(String name) {
        this.name = name;
    }
    public String getCurrency() {
        return currency;
    }
    public void setCurrency(String currency) {
        this.currency = currency;
    }
    public String getPrice_discount() {
        return price_discount;
    }
    public void setPrice_discount(String price_discount) {
        this.price_discount = price_discount;
    }
    public String getDelivery_charges() {
        return delivery_charges;
    }
    public void setDelivery_charges(String delivery_charges) {
        this.delivery_charges = delivery_charges;
    }
    public String getPay_money_method() {
        return pay_money_method;
    }
    public void setPay_money_method(String pay_money_method) {
        this.pay_money_method = pay_money_method;
    }
    public String getPayment_method() {
        return payment_method;
    }
    public void setPayment_method(String payment_method) {
        this.payment_method = payment_method;
    }
    public String getRemarks() {
        return remarks;
    }
    public void setRemarks(String remarks) {
        this.remarks = remarks;
    }
}
