<?php

namespace repositories;

use \models\Product;
use \models\User;

class ProductRepository extends BaseRepository
{
    function getProducts(): array
    {
        $query = $this->bd->query('SELECT * FROM products WHERE inventory >= 1 AND isDel = 0');
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\Product::class);
    }

    function getProductsBySeller(User $seller): array
    {
        $query = $this->bd->prepare('SELECT * FROM products WHERE seller = :seller AND isDel = 0');
        $query->bindValue(':seller', $seller->id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\Product::class);
    }

    function getCreatedProduct(User $seller): array
    {
        $query = $this->bd->prepare('SELECT * from products WHERE seller = :seller ORDER BY id DESC LIMIT 1');
        $query->bindValue(':seller', $seller->id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\Product::class);
    }

    function getProductById(int $productId): array
    {
        $query = $this->bd->prepare('SELECT * FROM products WHERE id = :productId AND isDel = 0');
        $query->bindValue(':productId', $productId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\Product::class);

    }

    function createProduct(Product $product): void
    {
        $query = $this->bd->prepare('INSERT INTO products (id, name, description,inventory,img,price,seller) VALUES (NULL, :name, :description, :inventory, :img, :price, :seller)');
        $query->bindValue(':name', $product->name, \PDO::PARAM_STR);
        $query->bindValue(':description', $product->description, \PDO::PARAM_STR);
        $query->bindValue(':inventory', $product->inventory, \PDO::PARAM_INT);
        $query->bindValue(':img', $product->img, \PDO::PARAM_STR);
        $query->bindValue(':price', $product->price, \PDO::PARAM_STR);
        $query->bindValue(':seller', $product->seller, \PDO::PARAM_INT);
        $query->execute();
    }

    function updateProduct(Product $product): void
    {
        $query = $this->bd->prepare('UPDATE products SET name = :name, description = :description, inventory = :inventory,  img = :img, price = :price,seller = :seller WHERE id = :id ');
        $query->bindValue(':name', $product->name, \PDO::PARAM_STR);
        $query->bindValue(':description', $product->description, \PDO::PARAM_STR);
        $query->bindValue(':inventory', $product->inventory, \PDO::PARAM_INT);
        $query->bindValue(':img', $product->img, \PDO::PARAM_STR);
        $query->bindValue(':price', $product->price, \PDO::PARAM_STR);
        $query->bindValue(':seller', $product->seller, \PDO::PARAM_INT);
        $query->bindValue(':id', $product->id, \PDO::PARAM_INT);
        $query->execute();
    }

    function DeleteProduct(Product $product): void
    {
        $query = $this->bd->prepare('UPDATE products SET isDel = 1 WHERE id = :id');
        $query->bindValue(':id', $product->id, \PDO::PARAM_INT);
        $query->execute();
    }


}