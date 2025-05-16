<?php

class Sale {
    public $id;
    public $total;
    public $payment_method;
    public $payment_details;
    public $status;
    public $user_id;
    public $shipping_name;
    public $shipping_address;
    public $shipping_city;
    public $shipping_phone;
    public $created_at;
    public $updated_at;

    public function __construct(
        $id,
        $total,
        $payment_method,
        $payment_details,
        $status,
        $user_id,
        $shipping_name,
        $shipping_address,
        $shipping_city,
        $shipping_phone,
        $created_at,
        $updated_at
    ) {
        $this->id = $id;
        $this->total = $total;
        $this->payment_method = $payment_method;
        $this->payment_details = $payment_details;
        $this->status = $status;
        $this->user_id = $user_id;
        $this->shipping_name = $shipping_name;
        $this->shipping_address = $shipping_address;
        $this->shipping_city = $shipping_city;
        $this->shipping_phone = $shipping_phone;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
