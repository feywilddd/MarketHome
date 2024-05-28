<?php

namespace Controllers;

use utils\utils;

class ApiController
{
    function getError(\repositories\ProductRepository $repo, mixed $productId, string $error): string
    {
        $currenProduct = $repo->getProductById($productId)[0];
        $newInventory = $currenProduct->inventory - $_SESSION['products'][$productId];
        if ($newInventory <= 0) {
            $error = ("Désoler, il ne reste plus asser de : " . $currenProduct->name . " en inventaire");
        } else {
            $_SESSION['products'][$productId] += 1;
            $_SESSION['nbItems']++;
        }
        return $error;
    }

    function getProducts(\repositories\ProductRepository $repo, int $id, array $products, mixed $productId, string $error)
    {
        foreach ($_SESSION['products'] as $product => $quantity) {
            $productSet = array();
            array_push($productSet, $repo->getProductById(array_keys($_SESSION['products'])[$id])[0], $quantity);
            $products[] = $productSet;
            $id++;
        }

        $utils = new Utils();
        $subTotal = number_format($utils->calculateSubTotal($products), 2);
        $tps = number_format($utils->calculateTPS($subTotal), 2);
        $tvq = number_format($utils->calculateTVQ($subTotal), 2);
        $total = number_format($utils->calculateTotal($subTotal, $tps, $tvq), 2);
        echo json_encode(array('id' => $productId, 'nbItems' => $_SESSION['products'][$productId], 'subTotal' => $subTotal, 'tps' => $tps, 'tvq' => $tvq, 'total' => $total, 'inventory' => $_SESSION['products'][$productId], 'error' => $error, 'totalItems' => strval($_SESSION['nbItems'])));
    }

    public function api()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf']) && ($_POST['csrf'] == $_SESSION['csrf_shop'] || $_POST['csrf'] == $_SESSION['csrf_home'])) {
            if (isset($_POST['id'])) {
                $error = '';
                $productId = $_POST['id'];
                $id = 0;
                $products = array();
                $repo = new \repositories\ProductRepository();
                if (!isset($_SESSION['products'])) {
                    $_SESSION['products'] = array();
                }
                if (!isset($_SESSION['products'][$productId])) {
                    $_SESSION['products'][$productId] = 0;
                }
                if ($_POST['btnType'] == 'addCart') {
                    $error = $this->getError($repo, $productId, $error);
                    echo json_encode(array('error' => $error, 'nbItems' => strval($_SESSION['nbItems'])));
                } else if ($_POST['btnType'] == 'add') {
                    $error = $this->getError($repo, $productId, $error);
                    $this->getProducts($repo, $id, $products, $productId, $error);
                } else if ($_POST['btnType'] == 'rem') {
                    $_SESSION['products'][$productId] -= 1;
                    $_SESSION['nbItems']--;
                    $this->getProducts($repo, $id, $products, $productId, $error);
                }

            } else {
                echo json_encode(array('success' => false, 'message' => 'Product ID not provided.'));
            }
        } else {
            http_response_code(400);
            echo json_encode(array('success' => false, 'message' => 'Only POST requests are allowed.'));
        }

    }
}