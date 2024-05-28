<?php
/**
 * @var $products \models\models\Product[]
 * @var $error string
 * @var $success bool
 * @var $tps string
 * @var $tvq string
 * @var $subTotal string
 * @var $total string
 */
$utils = new \utils\utils();
?>
<div class="mt-5 pt-5"></div>
<?php if ($error != '') {
    ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?></div>
<?php } ?>
<div class="row justify-content-around">
    <div class="gap-3 col-8">
        <h2 class="text-white">Votre panier</h2>
        <ul class="list-group">
            <?php foreach ($products as $product) {
                if ($product[1] > 0) { ?>
                    <li class="list-group-item " id="cartProduct<?= $product[0]->id ?>">
                        <div class="d-flex justify-content-between text-center">
                            <div class="d-flex text-center">
                                <h4 class="m-1 product"><?= $utils->xss_safe($product[0]->name) ?> : <span
                                            id="price<?= $product[0]->id ?>"><?= $utils->xss_safe(number_format($product[0]->price, 2)) ?></span>$
                                </h4>
                            </div>
                            <div>
                                <span class="badge text-bg-info"><p
                                            id="item<?= $product[0]->id ?>"><?= $utils->xss_safe($product[1]) ?></p></span>
                                <button class="btn btn-primary" data-ProductId="<?= $product[0]->id ?>"
                                        data-BtnType="add" id="btnAdd2" role="button">
                                    <i class="bi bi-bag-plus"></i>
                                </button>
                                <button class="btn btn-danger" data-ProductId="<?= $product[0]->id ?>"
                                        data-BtnType="rem" id="btnRem2" role="button">
                                    <i class="bi bi-bag-x"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                <?php }
            } ?>
        </ul>
    </div>
    <div class="gap-3 col-3">
        <h2 class="text-white">Votre Total</h2>
        <ul class="list-group">
            <li class="list-group-item ">
                <div class="d-flex justify-content-between text-center">
                    <div class="d-flex text-center">
                        <h5 class="m-1">Sous-total</h5>
                    </div>
                    <div>
                        <p class="text-secondary mt-1" id="subTotal"><?= $success ? number_format($subTotal, 2) : '' ?>
                            $</p>
                    </div>
                </div>
            </li>
            <li class="list-group-item ">
                <div class="d-flex justify-content-between text-center">
                    <div class="d-flex text-center">
                        <h5 class="m-1">TPS</h5>
                    </div>
                    <div>
                        <p class="text-secondary mt-1" id="tps"><?= $success ? number_format($tps, 2) : '' ?>$</p>
                    </div>
                </div>
            </li>
            <li class="list-group-item ">
                <div class="d-flex justify-content-between text-center">
                    <div class="d-flex text-center">
                        <h5 class="m-1">TVQ</h5>
                    </div>
                    <div>
                        <p class="text-secondary mt-1" id="tvq"><?= $success ? number_format($tvq, 2) : '' ?>$</p>
                    </div>
                </div>
            </li>
            <li class="list-group-item ">
                <div class="d-flex justify-content-between text-center ">
                    <div class="d-flex text-center ">
                        <h5 class="m-1 ">Total</h5>
                    </div>
                    <div>
                        <p id="total"><?= $success ? number_format($total, 2) : '' ?>$</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <h2 class="text-white mt-5">Paiement</h2>
    <form method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="NameInputs" class="form-label text-white">Nom</label>
            <input type="text" class="form-control " id="NameInput" name="NameInput" required>
        </div>
        <div class="mb-3">
            <label for="LastNameInputs" class="form-label text-white">Nom de famille</label>
            <input type="text" class="form-control" id="LastNameInput" name="LastNameInput" required>
        </div>
        <div class="mb-3">
            <label for="AdressInputs" class="form-label text-white">Adresse de facturation et de livraison</label>
            <input type="text" class="form-control" id="AdressInput" name="AdressInput" required>
            <div id="address" class="form-text text-white">Si avoir la même adresse de facturation et de livraison cause
                problème, appelez le service à la clientèle au 450-917-2222
            </div>
        </div>
        <div class="mb-3">
            <label for="TownInputs" class="form-label text-white">Ville</label>
            <input type="text" class="form-control " id="TownInput" name="TownInput" required>
        </div>
        <div class="mb-3">
            <label for="PostalCodeInputs" class="form-label text-white">Code Postal</label>
            <input type="text" class="form-control" id="PostalCodeInput" name="PostalCodeInput" required>
        </div>
        <div class="mb-3">
            <label for="PhoneInputs" class="form-label text-white">Numéro de téléphone</label>
            <input type="text" class="form-control" id="PhoneInput" name="PhoneInput" required>
        </div>
        <div class="mb-3">
            <label for="CardNumInputs" class="form-label text-white">Numéro de carte de crédit</label>
            <input type="text" class="form-control " id="CardNumInput" name="CardNumInput" required>
        </div>
        <div class="mb-3">
            <label for="CardExpInputs" class="form-label text-white">Date d'expiration (MM/YY)</label>
            <input type="text" class="form-control" id="CardExpInput" name="CardExpInput" required>
        </div>
        <div class="mb-3">
            <label for="CardCCVInputs" class="form-label text-white">Numéro de CCV</label>
            <input type="text" class="form-control" id="CardCCVInput" name="CardCCVInput" required>
        </div>
        <input type="hidden" name="csrf" id="csrf" value="<?= $_SESSION['csrf_shop'] ?>">
        <button type="submit" class="btn btn-primary my-3">Payer!</button>
    </form>
</div>
</div>
</body>
<script src="/JS/cartAPI.js"></script>
<script src="/JS/formValidator.js"></script>
<script src="/JS/self-xss.js"></script>
</html>
