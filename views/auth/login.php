<?php
/**
 * @var $error string
 * @var $username string
 */
$utils = new \utils\utils();
?>
<div class="mt-5 pt-5"></div>
<?php if ($error != '') { ?>
    <div class="alert alert-danger" role="alert">
        <?= $error ?></div>
<?php } ?>
<h1 class="display-1 text-white">Connectez-vous!</h1>
<form method="post" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="UsernameInputs" class="form-label text-white">Adresse Courriel</label>
        <input type="text" class="form-control " id="UsernameInput"
               name="UsernameInput" value="<?= $username ? $utils->xss_safe($username) : "" ?>" required>
    </div>
    <div class="mb-3">
        <label for="PasswordInputs" class="form-label text-white">Mot de passe</label>
        <input type="password" class="form-control" id="PasswordInput" name="PasswordInput" required>
    </div>
    <div class="mb-3 d-flex justify-content-center">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="RememberMe" name="RememberMe">
            <label class="form-check-label text-white" for="RememberMe">
                Se souvenir de moi
            </label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary my-3">Connectez-vous</button>
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_login'] ?>">
</form>
<div class="mt-5"></div>
<a href="../../auth/forgot" class="text-white mt-5">J'ai oublié mon mot de passe</a>

</div>
</body>
<script src="/JS/formValidator.js"></script>
<script src="/JS/self-xss.js"></script>
</html>