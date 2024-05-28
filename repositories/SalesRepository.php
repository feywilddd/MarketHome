<?php

namespace repositories;

use models\Product;
use models\Sale;
use models\User;

class SalesRepository extends BaseRepository
{
    function getSalesByBuyer(User $user): array
    {
        $query = $this->bd->prepare('SELECT sales.id, sales.date, products.name, products.price, sales.quantity FROM sales JOIN products ON sales.product_id = products.id WHERE sales.buyer_id = :buyer');
        $query->bindValue(':buyer', $user->id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\Sale::class);
    }

    function getSalesBySeller(User $user): array
    {
        $query = $this->bd->prepare('SELECT sales.id, sales.date, products.name, products.price, sales.quantity FROM sales JOIN products ON sales.product_id = products.id WHERE products.seller = :seller');
        $query->bindValue(':seller', $user->id, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\Sale::class);
    }

    function createSale(Product $product, int $quantity, User $buyer, string $card): void
    {
        $query = $this->bd->prepare('INSERT INTO sales (id, date, buyer_id, quantity, product_id, cardNum) VALUES (NULL, CURRENT_DATE, :buyer_id, :quantity, :product_id, :card)');
        $query->bindValue(':buyer_id', $buyer->id, \PDO::PARAM_INT);
        $query->bindValue(':quantity', $quantity, \PDO::PARAM_INT);
        $query->bindValue(':product_id', $product->id, \PDO::PARAM_INT);
        $query->bindValue(':card', intval($card), \PDO::PARAM_INT);
        $query->execute();
    }

    function GetSale(): array
    {
        $query = $this->bd->prepare('SELECT sales.id, sales.date, sales.product_id, sales.buyer_id, sales.quantity FROM sales ORDER BY id DESC LIMIT 1');
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, \models\Sale::class);
    }
}