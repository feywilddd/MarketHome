<?php
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
<h1 class="display-1 mt-5 pt-5 text-white">Changer mon mot de passe</h1>
<form method="post" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="UsernameInputs" class="form-label text-white">Adresse Courriel</label>
        <input type="text" class="form-control " id="UsernameInput"
               name="UsernameInput" value="<?= $username ? $utils->xss_safe($username) : "" ?>" required>
    </div>
    <button type="submit" class="btn btn-primary my-3">Connectez-vous</button>
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_login'] ?>">
</form>
</div>
</body>
<script src="/JS/formValidator.js"></script>
<script src="/JS/self-xss.js"></script>
</html>