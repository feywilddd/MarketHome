<?php
/**
 * @var $products \models\models\Product[]
 */
$utils = new \utils\utils();
?>
<h1 class="display-1 text-center mt-5 pt-5 text-white">Mes produits</h1>
<div class="row mt-5 ">
    <div class="col d-flex justify-content-center">
        <div class="card mt-5" id="AddingCard">
            <div class="card-body d-flex flex-column justify-content-center align-content-center ">
                <h5 class="card-title text-white ">Ajouter un produit</h5>
                <a href="AddProduct" class="btn btn-primary mt-5 ">Ajouter!</a>
            </div>
        </div>
    </div>
    <?php foreach ($products as $product) { ?>
        <div class="col d-flex justify-content-center">
            <div class="card mt-5">
                <img src="../..<?= $product->img ?>" class="card-img-top " alt="">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title "><?= $utils->xss_safe($product->name) ?></h5>
                    <p class="card-text "><?= $utils->xss_safe($product->description) ?></p>
                    <p class="card-text ">Prix : <?= $utils->xss_safe($product->price) ?></p>
                    <p class="card-text ">Inventaire : <?= $utils->xss_safe($product->inventory) ?></p>
                    <a href="modify/<?= $utils->xss_safe($product->id) ?>" class="btn btn-primary mt-auto">Modifier
                        votre article</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
</div>
</body>
<script src="/JS/self-xss.js"></script>
</html>