<?php
/**
 * @var $product \models\models\Product
 * @var $error string
 */
$utils = new \utils\utils();
?>
<h1 class="display-1 text-center mt-5 pt-5 text-white">Modifier votre produit</h1>
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
        <input type="number"

               class="form-control" id="InventoryInput" name="InventoryInput"
               value="<?= $utils->xss_safe($product->inventory) ?>" required>
    </div>
    <div class="mb-3">
        <label for="ImgInput" class="form-label text-white">Image du produit</label>
        <input type="file" class="form-control" id="ImgInput" name="ImgInput" accept="image/*">
    </div>
    <label id="gainLabel" class="form-label text-white">Afin de rester en activité, MarketHome se prendre une cote sur
        votre vente d'une valeur de : <?= $utils->xss_safe(number_format($product->price * 0.02 + 0.30, 2)) ?>$</label>
    <div class="mb-3">
        <label for="ActionInput" class="form-label text-white">Je souhaite : </label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="InputRadio" id="Modify" value="1" checked required>
            <label class="form-check-label text-white" for="Modify">Modifier mon produit</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="InputRadio" id="Delete" value="2" required>
            <label class="form-check-label text-white" for="Delete">Supprimer mon produit</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary my-3">Appliquer!</button>
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_mod'] ?>">
</form>
<?php if ($error != '') { ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?></div>
<?php } ?>
</div>
</body>
<script src="/JS/formValidator.js"></script>
<script src="/JS/gainCalc.js"></script>
<script src="/JS/self-xss.js"></script>
</html>