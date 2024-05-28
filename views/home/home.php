<?php
/**
 * @var $login bool
 * @var $firstLog bool
 * @var $products \models\models\Product[]
 * @var $error string
 */
$utils = new \utils\utils();
?>
<div class="mt-5 pt-5"></div>
<?php if ($firstLog) { ?>
    <div class="alert alert-success" role="alert">Vous êtes connecté</div>
<?php } ?>
<?php if ($error) { ?>
    <div class="alert alert-danger" role="alert"><?= $error ?></div>
<?php } ?>
<div class="alert alert-danger d-none" role="alert" id="errorAlert"></div>
<h1 class="display-1 text-center mt-3 text-white">MarketHome</h1>
<h2 class="text-center text-white">More then just a place</h2>
<div class="row mt-5 ">
    <?php foreach ($products as $product) {
        if (!$product->inventory < 1) {
            ?>
            <div class="col d-flex justify-content-center">
                <div class="card mt-5 ">
                    <img src="../..<?= $product->img ?>" class="card-img-top " alt="">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title "><?= $utils->xss_safe($product->name) ?></h5>
                        <p class="card-text "><?= $utils->xss_safe($product->description) ?></p>
                        <p class="card-text ">Prix : <?= $utils->xss_safe($product->price) ?> $</p>
                        <p class="card-text ">Inventaire : <?= $utils->xss_safe($product->inventory) ?></p>
                        <button id="addToCart" data-ProductId="<?= $utils->xss_safe($product->id) ?>"
                                class="btn <?php if (!$login) echo 'disabled' ?> btn-primary mt-auto">Ajouter au panier
                        </button>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
    <input type="hidden" name="csrf" id="csrf" value="<?= $_SESSION['csrf_home'] ?>">
</div>
</div>
</body>
<script src="/JS/IndexAPI.js"></script>
<script src="/JS/self-xss.js"></script>
</html>