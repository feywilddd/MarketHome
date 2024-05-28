<?php
/**
 * @var $error string
 * @var $success bool
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
            <label for="newPassword" class="form-label text-white">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
        </div>
        <div class="mb-3">
            <label for="confirmPassword" class="form-label text-white">Confirmer le nouveau mot de passe</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_change'] ?>">
    </form>
</div>
</body>
<script src="/JS/formValidator.js"></script>
<script src="/JS/self-xss.js"></script>
</html>