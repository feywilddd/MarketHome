<?php

namespace models;

class Product
{
    public int $id;
    public string $name;
    public float $price;
    public string $description;
    public string $img;
    public int $seller;
    public int $inventory;
    public int $isDel;

}