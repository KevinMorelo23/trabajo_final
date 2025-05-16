<?php
class Product {
    public $id;
    public $name;
    public $description;
    public $price;
    public $stock;
    public $category_id;
    public $provider_id;
    public $created_at;
    public $updated_at;

    // Agregar estas propiedades:
    public $price_with_discount;
    public $has_promotion;
    public $discount_percent;

    public function __construct($id, $name, $description, $price, $stock, $category_id, $provider_id, $created_at, $updated_at) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category_id = $category_id;
        $this->provider_id = $provider_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;

        // Inicializar valores por defecto
        $this->price_with_discount = $price;
        $this->has_promotion = false;
        $this->discount_percent = 0;
    }
}

