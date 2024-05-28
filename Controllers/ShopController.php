<?php

namespace Controllers;

use repositories\SalesRepository;
use utils\utils;

class ShopController
{
    public function shop()
    {
        $utils = new Utils();
        $products = array();
        $success = false;
        $repo = new \repositories\ProductRepository();
        $salesRepo = new \repositories\SalesRepository();
        $error = '';
        if (!isset($_SESSION['csrf_shop'])) {
            $csrf_token = $utils->hacherCSRF('shop');
            $_SESSION['csrf_shop'] = $csrf_token;
        }
        if (isset($_SESSION['user'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = 0;
                foreach ($_SESSION['products'] as $product => $quantity) {
                    if ($quantity) {
                        $currenProduct = $repo->getProductById((array_keys($_SESSION['products'])[$id]))[0];
                        $newInventory = $currenProduct->inventory - $quantity;
                        if ($newInventory < 0) {
                            $error = ("Désoler, il ne reste plus asser de : " . $currenProduct->name . " en inventaire");
                        }
                    }
                    $id++;
                }

                if ($_POST['NameInput'] == '' || $_POST['LastNameInput'] == '' || $_POST['AdressInput'] == '' || $_POST['TownInput'] == '' || $_POST['PostalCodeInput'] == '' || $_POST['PhoneInput'] == '' || $_POST['CardNumInput'] == '' || $_POST['CardExpInput'] == '' || $_POST['CardCCVInput'] == '') {
                    $error = 'Veuiller remplir tout les champs du formulaire';
                } else {
                    $cardNumber = preg_replace('/\D/', '', $_POST['CardNumInput']);
                    $expirationDate = $_POST['CardExpInput'];
                    if (strlen($cardNumber) !== 16 || !is_numeric($cardNumber) || strlen($_POST['CardCCVInput']) !== 3 || !is_numeric($_POST['CardCCVInput'])) {
                        $error = 'Veuiller entrer une carte de crédit valide';
                    } else if (!preg_match('/^(0[1-9]|1[0-2])\/[0-9]{2}$/', $expirationDate)) {
                        $error = 'Veuillez entrer une date d\'expiration de carte valide (MM/YY)';
                    } else if ($_SESSION['nbItems'] == 0) {
                        $error = "Vous n'avez rien dans le panier";
                    } else {
                        $parts = explode('/', $expirationDate);
                        $expMonth = intval($parts[0]);
                        $expYear = intval('20' . $parts[1]);

                        $currentMonth = intval(date('m'));
                        $currentYear = intval(date('Y'));

                        if ($expYear < $currentYear || ($expYear == $currentYear && $expMonth < $currentMonth)) {
                            $error = 'La carte a expiré';
                        }
                    }
                }
                if ($error == '') {
                    $id = 0;
                    $lastFourDigits = substr($cardNumber, -4);
                    foreach ($_SESSION['products'] as $product => $quantity) {
                        if ($quantity) {
                            $currenProduct = $repo->getProductById((array_keys($_SESSION['products'])[$id]))[0];
                            $currenProduct->inventory -= $quantity;
                            $repo->updateProduct($currenProduct);
                            $salesRepo->createSale($currenProduct, $quantity, $_SESSION['user'], $lastFourDigits);
                            $newSale = $salesRepo->GetSale();
                            $saleString = $newSale[0]->id . ',' . $newSale[0]->product_id . ',' . $newSale[0]->buyer_id . ',' . $newSale[0]->date . ',' . $newSale[0]->quantity . ',' . $lastFourDigits;
                            file_put_contents('../utils/backup.csv', $saleString . PHP_EOL, FILE_APPEND);
                        }
                        $id++;
                    }
                    $_SESSION['nbItems'] = 0;
                    $_SESSION['products'] = array();
                    header('location: ../index.php');
                    die();
                }
                if (isset($_SESSION['products'])) {
                    $id = 0;
                    foreach ($_SESSION['products'] as $product => $quantity) {
                        $productSet = array();
                        array_push($productSet, $repo->getProductById(array_keys($_SESSION['products'])[$id])[0], $quantity);
                        $products[] = $productSet;
                        $id++;
                    }
                    $subTotal = $utils->calculateSubTotal($products);
                    $tps = $utils->calculateTPS($subTotal);
                    $tvq = $utils->calculateTVQ($subTotal);
                    $total = $utils->calculateTotal($subTotal, $tvq, $tps);
                    $success = true;
                    $login = $_SESSION['user'];
                }
            } elseif (isset($_SESSION['products'])) {
                $id = 0;
                foreach ($_SESSION['products'] as $product => $quantity) {
                    $productSet = array();
                    array_push($productSet, $repo->getProductById(array_keys($_SESSION['products'])[$id])[0], $quantity);
                    $products[] = $productSet;
                    $id++;
                }
                $subTotal = $utils->calculateSubTotal($products);
                $tps = $utils->calculateTPS($subTotal);
                $tvq = $utils->calculateTVQ($subTotal);
                $total = $utils->calculateTotal($subTotal, $tvq, $tps);
                $success = true;
                $login = $_SESSION['user'];
            }
            require_once '../views/_navConnected.php';
            require_once '../views/shop/shop.php';
        } else {
            header('location: ../auth/login');
            die();
        }
    }
}