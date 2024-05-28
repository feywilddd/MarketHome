<?php

namespace models;

class Sale
{
    public int $id;
    public string $name;
    public float $price;
    public string $date;
    public int $quantity;
    public int $buyer_id;
    public int $product_id;
}