<?php
/**
 * @var $sales \models\models\Sale[]
 * @var $buys \models\models\Sale[]
 * @var $error string
 * @var $success bool
 * @var $tps string
 * @var $tvq string
 * @var $subTotal string
 * @var $total string
 */
$utils = new \utils\utils();
?>
<div class="row justify-content-around">
    <div class="mt-5 pt-5"></div>
    <?php if ($error != '') {
        ?>
        <div class="alert alert-danger" role="alert"><?= $error ?></div>
    <?php } ?>
    <?php if ($success != '') {
        ?>
        <div class="alert alert-success" role="alert"><?= $success ?></div>
    <?php } ?>
    <h4 class="display-4 text-white">Changer de mot de passe</h4>
    <form method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="oldPassword" class="form-label text-white">Ancien mot de passe</label>
            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
        </div>
        <div class="mb-3">
            <label for="newPassword" class="form-label text-white">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label text-white">Confirmer le nouveau mot de passe</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_acc'] ?>">
    </form>
    <div class="col-6">
        <h4 class="display-4 mt-3 pt-3 text-white">Mes Achats</h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Commande</th>
                <th scope="col">Produit</th>
                <th scope="col">Quantité</th>
                <th scope="col">Coût</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($buys as $buy) { ?>
                <tr>
                    <th scope="row"><?= $utils->xss_safe($buy->id) ?></th>
                    <td><?= $utils->xss_safe($buy->name) ?></td>
                    <td><?= $utils->xss_safe($buy->quantity) ?></td>
                    <td><?= $utils->xss_safe(number_format($buy->price, 2)) ?>$</td>
                    <td><?= $utils->xss_safe($buy->date) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-6">
        <h4 class="display-4 mt-3 pt-3 text-white">Mes Ventes</h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Commande</th>
                <th scope="col">Produit</th>
                <th scope="col">Quantité</th>
                <th scope="col">Gain</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sales as $sale) { ?>
                <tr>
                    <th scope="row"><?= $utils->xss_safe($sale->id) ?></th>
                    <td><?= $utils->xss_safe($sale->name) ?></td>
                    <td><?= $utils->xss_safe($sale->quantity) ?></td>
                    <td><?= $utils->xss_safe(number_format($sale->price, 2)) ?>$</td>
                    <td><?= $utils->xss_safe($sale->date) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</body>
<script src="/JS/formValidator.js"></script>
<script src="/JS/self-xss.js"></script>
</html>
