<?php

class Provider {
    public $id;
    public $name;
    public $email;
    public $phone;
    public $address;
    public $created_at;
    public $updated_at;

    public function __construct($id, $name, $email, $phone, $address, $created_at, $updated_at) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
