<?php

namespace Controllers;

use utils\utils;

class AccountController
{
    public function account()
    {
        $products = array();
        $success = '';
        $repo = new \repositories\SalesRepository();
        $error = null;
        $utils = new utils();
        if (!isset($_SESSION['csrf_acc'])) {
            $csrf_token = $utils->hacherCSRF('acc');
            $_SESSION['csrf_acc'] = $csrf_token;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_acc']) {
            if (empty($_POST['oldPassword']) || empty($_POST['newPassword']) || empty($_POST['confirmPassword'])) {
                $error = 'Veuillez remplir tous les champs';
            } elseif ($_POST['newPassword'] !== $_POST['confirmPassword']) {
                $error = 'Les nouveaux mots de passe ne correspondent pas';
            } elseif (strlen($_POST['newPassword']) < 8) {
                $error = 'Veuiller entrer un mot de passe de plus de 8 caractères';
            } else {
                $repoUsers = new \repositories\UserRepository();
                $user = new \models\User();
                $user = $repoUsers->searchUser($_SESSION['user'])[0];
                if (!password_verify($_POST['oldPassword'], $user->password)) {
                    $error = 'L\'ancien mot de passe est incorrect';
                } else {
                    $hashedPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
                    $repoUsers->updatePassword($_SESSION['user']->id, $hashedPassword);
                    $success = 'Votre mot de passe à bien été modifier';
                }
            }
        }
        if (isset($_SESSION['user'])) {
            $buys = $repo->getSalesByBuyer($_SESSION['user']);
            foreach ($buys as $buy) {
                $subtotal = $buy->price * $buy->quantity;
                $buy->price = $utils->calculateTotal($subtotal, $utils->calculateTVQ($subtotal), $utils->calculateTPS($subtotal));
            }
            $sales = $repo->getSalesBySeller($_SESSION['user']);
            foreach ($sales as $sale) {
                $subtotal = $sale->price * $sale->quantity;
                $sale->price = $utils->calculateGains($subtotal, $sale->quantity);
            }
            require_once '../views/_navConnected.php';
            require_once '../views/account/account.php';
        } else {
            header('location: ../auth/login');
            die();
        }
    }
}