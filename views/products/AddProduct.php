<?php
/**
 * @var $product \models\models\Product
 * @var $error string
 */
$utils = new \utils\utils();
?>
<h1 class="display-1 text-center mt-5 pt-5 text-white">Ajouter un produit</h1>
<form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="NameInput" class="form-label text-white">Nom du produit</label>
        <input type="text" class="form-control " id="NameInput" name="NameInput"
               value="<?= $utils->xss_safe($product->name) ?>" required>
    </div>
    <div class="mb-3">
        <label for="DescriptionInput" class="form-label text-white">Description du produit</label>
        <textarea class="form-control" id="DescriptionInput" name="DescriptionInput" maxlength="150"
                  required> <?= $utils->xss_safe($product->description) ?></textarea>
    </div>
    <div class="mb-3">
        <label for="PriceInput" class="form-label text-white">Prix du produit</label>
        <input type="number" step="0.01" min="2" class="form-control" id="PriceInput" name="PriceInput"
               value="<?= $utils->xss_safe($product->price) ?>" required>
    </div>
    <div class="mb-3">
        <label for="InventoryInput" class="form-label text-white">Inventaire du produit</label>
        <input type="number" class="form-control" min="1" id="InventoryInput" name="InventoryInput"
               value="<?= $utils->xss_safe($product->inventory) ?>" required>
    </div>
    <div class="mb-3">
        <label for="ImgInput" class="form-label text-white">Image du produit</label>
        <input type="file" class="form-control" id="ImgInput" name="ImgInput" required accept="image/*">
    </div>
    <div class="mb-1">
        <label id="gainLabel" class="form-label text-white">Afin de rester en activité, MarketHome se prendre une cote
            sur votre vente.</label>
    </div>
    <button type="submit" class="btn btn-primary my-3">Ajouter!</button>
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_addP'] ?>">
</form>
<?php if ($error != '') { ?>
    <div class="alert alert-danger" role="alert"><?= $error ?></div>
<?php } ?>
</div>
</body>
<script src="/JS/formValidator.js"></script>
<script src="/JS/gainCalc.js"></script>
<script src="/JS/self-xss.js"></script>
</html>