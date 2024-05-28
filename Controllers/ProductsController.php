<?php

namespace Controllers;

use \models\User;
use utils\utils;

class ProductsController
{
    public function addProduct()
    {
        if (isset($_SESSION['user'])) {
            $utils = new utils();
            $product = new \models\Product();
            $productNew = new \models\Product();
            $repo = new \repositories\ProductRepository();
            $login = $_SESSION['user'];
            if (!isset($_SESSION['csrf_addP'])) {
                $csrf_token = $utils->hacherCSRF('addP');
                $_SESSION['csrf_addP'] = $csrf_token;
            }
            $error = null;
            $product->name = "";
            $product->description = "";
            $product->seller = $login->id;
            $product->price = round(0, 2);
            $product->inventory = 1;

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_addP']) {
                $product->name = $_POST['NameInput'];
                $product->description = $_POST['DescriptionInput'];
                $product->seller = $login->id;
                $product->price = round($_POST['PriceInput'], 2);
                $product->inventory = $_POST['InventoryInput'];
                if (floatval($_POST['PriceInput']) > 0 && intval($_POST['InventoryInput']) > 0) {
                    $target_dir = "../html/img/";
                    $target_file = $target_dir . basename($_FILES['ImgInput']["name"]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                    if ($_FILES['ImgInput']['error'] == 1) {
                        $error = "Votre image est trop volumineuse";

                    }

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" && $imageFileType != "webp") {
                        $error = "Seul les types de fichier d'image sont accepter";

                    }

                    if ($error == '') {
                        $product->img = '/img/' . $_FILES['ImgInput']['name'];
                        $repo->CreateProduct($product);
                        $productNew = $repo->getCreatedProduct($login)[0];
                        move_uploaded_file($_FILES['ImgInput']["tmp_name"], $target_dir . $productNew->id . "." . $imageFileType);
                        $productNew->img = '/img/' . $productNew->id . "." . $imageFileType;
                        $repo->UpdateProduct($productNew);
                        header('location: ../../products/products');
                        die();
                    }

                } else {
                    $error = 'Veuiller entrer des valeurs positives';
                }
            }
            require_once '../views/_navConnected.php';
            require_once '../views/products/AddProduct.php';
        } else {
            header('location: ../../auth/login');
            die();
        }

    }

    public function modify(int $productId)
    {
        if (isset($_SESSION['user'])) {
            $utils = new utils();
            $login = $_SESSION['user']->id;
            $repo = new \repositories\ProductRepository();
            $product = $repo->getProductById($productId)[0];
            if (!isset($_SESSION['csrf_mod'])) {
                $csrf_token = $utils->hacherCSRF('mod');
                $_SESSION['csrf_mod'] = $csrf_token;
            }
            $error = null;
            if ($_SESSION['user']->id == $product->seller) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf_mod']) {
                    if ($_POST['InputRadio'] == '1') {
                        if (($_POST['NameInput'] != '') && ($_POST['DescriptionInput'] != '') && ($_POST['PriceInput'] != '') && ($_POST['InventoryInput'] != '')) {
                            if (floatval($_POST['PriceInput']) > 0 && intval($_POST['InventoryInput']) > 0) {
                                $product->name = $_POST['NameInput'];
                                $product->description = $_POST['DescriptionInput'];
                                $product->price = round($_POST['PriceInput'], 2);
                                $product->inventory = $_POST['InventoryInput'];
                                if ($_FILES['ImgInput']['name'] != '') {
                                    $target_dir = "../html/img/";
                                    $target_file = $target_dir . basename($_FILES['ImgInput']["name"]);
                                    $uploadOk = 0;
                                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                    $mimeType = mime_content_type($_FILES['ImgInput']);

                                    $_FILES['ImgInput']['error'] == 0 ? $uploadOk = 1 : $error = "Votre image est trop volumineuse";
                                    $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "jpg" ? $uploadOk = 1 : $error = "Seul les types de fichier d'image sont accepter";
                                    $mimeType == "image/png" || $mimeType == "image/jpeg" ? $uploadOk = 1 : $error = "Seul les types de fichier d'image sont accepter";

                                    if ($uploadOk == 1) {
                                        @unlink('../html/' . $product->img);
                                        move_uploaded_file($_FILES['ImgInput']["tmp_name"], $target_dir . $productId . "." . $imageFileType);
                                        $product->img = '/img/' . $productId . "." . $imageFileType;
                                    }
                                }
                                if (!$error) {
                                    $repo->UpdateProduct($product);
                                    header('location: ../../products/products');
                                    die();
                                }
                            } else {
                                $error = 'Veuiller entrer des valeurs positives';
                            }
                        } else {
                            $error = 'Veuiller ne laisser aucun champ vide';
                        }

                    } else {
                        @unlink('../html/' . $product->img);
                        $repo->DeleteProduct($product);
                        header('location: ../../products/products');
                        die();
                    }

                }
                require_once '../views/_navConnected.php';
                require_once '../views/products/modifyProduct.php';

            } else {
                header('location: ../../auth/login');
                die();
            }

        } else {
            header('location: ../../auth/login');
            die();
        }
    }

    public function products()
    {
        if (isset($_SESSION['user'])) {
            $repo = new \repositories\ProductRepository();
            $login = $_SESSION['user'];
            $products = $repo->getProductsBySeller($login);
            require_once '../views/_navConnected.php';
            require_once '../views/products/products.php';
        } else {
            header('location: ../../auth/login');
            die();
        }

    }
}