<?php
declare(strict_types=1);
/**
 * @var $error string
 * @var $username string
 * @var $success string
 */
$utils = new \utils\utils();
?>
<div class="mt-5 pt-5"></div>
<?php if ($error != '') {
    ?>
    <div class="alert alert-danger" role="alert"><?= $error ?></div>
<?php } ?>
<?php if ($success != '') {
    ?>
    <div class="alert alert-success" role="alert"><?= $success ?></div>
<?php } ?>
<h1 class="display-1 text-center text-white">Créer un compte!</h1>
<form method="post" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="UsernameInputs" class="form-label text-white">Adresse Courriel</label>
        <input type="text" class="form-control " id="UsernameInput" name="UsernameInput"
               value="<?= $username ? $utils->xss_safe($username) : "" ?>" maxlength="255" required>
    </div>
    <div class="mb-3">
        <label for="PasswordInputs" class="form-label text-white">Mot de passe</label>
        <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" minlength="8"
               maxlength="255" required>
    </div>
    <div class="mb-3">
        <label for="PasswordConfirmationInputs" class="form-label text-white"> Confirmer le mot de passe</label>
        <input type="password" class="form-control" id="PasswordConfirmationInput" name="PasswordConfirmationInput"
               minlength="8" maxlength="255" required>
    </div>
    <button type="submit" class="btn btn-primary my-3">Créer un compte</button>
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_register'] ?>">
</form>
</div>
</body>
<script src="/JS/formValidator.js"></script>
<script src="/JS/self-xss.js"></script>
</html>