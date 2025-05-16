<?php

class Promotion {
    public $id;
    public $product_id;
    public $discount_percent;
    public $start_date;
    public $end_date;
    public $created_at;
    public $updated_at;

    public function __construct($id, $product_id, $discount_percent, $start_date, $end_date = null, $created_at = null, $updated_at = null) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->discount_percent = $discount_percent;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
