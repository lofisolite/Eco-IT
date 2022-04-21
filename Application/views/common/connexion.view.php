<?php
ob_start();
?>

<main id="main-connexion">
<h2>Connexion</h2>

<div class="d-flex justify-content-center">
    <form action="" method="POST" class="form d-flex flex-column" id="formConnexion">
        <p id="errorMsg" class="mb-3 error-msg"><?= $alert ?></p>
        <div class="mb-3">
            <p id="errorMail" class="mb-3 error-msg"></p>
            <label for="mail" class="form-label">Adresse mail</label>
            <input type="email" class="form-control" id="mail" name="mail" value="<?= $_POST['mail'] ?? '' ?>" minlength="2" maxlength="80" required>
        </div>
        <div class="mb-3">
            <p id="errorPassword" class="mb-3 error-msg"></p>
            <label for="password" class="form-label">Mot de passe</label>
            <div class="container-password">
                <input type="password" class="form-control" id="password" name="password" value="<?= $_POST['password'] ?? '' ?>" min="2" max="80" required>
                <img id="eye" src="public/images/general/notvisible.png">
            </div>
        </div>
        <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
    </form>
</div>

</main>

<?php

$content = ob_get_clean();

$titleHead = 'connexion EcoIt';
$src = "script/form/general/verifyConnexion.js";

require_once "views/common/template.view.php";