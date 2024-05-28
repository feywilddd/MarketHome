<?php

namespace Controllers;

use utils\utils;

class HomeController
{
    public function home()
    {
        $utils = new utils();
        $error = null;
        if (!isset($_SESSION['csrf_home'])) {
            $csrf_token = $utils->hacherCSRF('home');
            $_SESSION['csrf_home'] = $csrf_token;
        }
        $repo = new \repositories\ProductRepository();
        $products = $repo->getProducts();
        if (isset($_SESSION['user'])) {
            require_once '../views/_navConnected.php';
            $login = true;
        } else {
            require_once '../views/_navAnonymous.php';
            $login = false;
        }
        if (isset($_SESSION['1login']) && $_SESSION['1login'] === true) {
            $firstLog = true;
        } else {
            $firstLog = false;
        }
        if (isset($_SESSION['errorMessage']))
            $error = $_SESSION['errorMessage'];
        require_once '../views/home/home.php';

        $_SESSION['1login'] = false;
        $_SESSION['errorMessage'] = '';
    }
}