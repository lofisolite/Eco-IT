<?php
ob_start();
?>

<main id="main-inscription">  
    <h2>Inscription apprenant</h2>
    <div class="d-flex justify-content-center" >
        <form action="" method="POST" class="form d-flex flex-column" id="formSinscription">

            <?php if(isset($error)) : ?>
            <p id="errorMsg" class="mb-3 error-msg"><?= $error ?></p>
            <?php endif ?>
            
            <div class="mb-3">
                <p id="errorPseudo" class="mb-3 error-msg"></p>
                <label for="pseudo" class="form-label">Pseudo</label>
                <p class="explication-msg mb-2">Seulements des lettres et des chiffres</p>
                <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= $_POST['pseudo'] ?? '' ?>" minlength="2" maxlength="50" required>
            </div>

            <div class="mb-3">
                <p id="errorMail" class="mb-3 error-msg"></p>
                <label for="mail" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="mail" name="mail" value="<?= $_POST['mail'] ?? '' ?>" minlength="2" maxlength="80" required>
            </div>

            <div class="mb-3">
                <p id="errorPassword" class="mb-3 error-msg"></p>
                <label for="password" class="form-label">Mot de passe</label>
                <p class="explication-msg mb-2">Minimum 10 caractères.<br> Au moins un chiffre, une majuscule et un caractère spécial ($@%*+\-_!?) obligatoires</p>
                <div class="container-password">
                    <input type="password" class="form-control" id="password" name="password" value="<?= $_POST['password'] ?? '' ?>" min="2" max="80" required>
                    <img id="eye" src="public/images/general/notvisible.png" alt="">
                </div>
            </div>
            <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
        </form>
    </div>
</main>

<?php
$content = ob_get_clean();

$titleHead = 'inscription apprenant';
// $src = '';
$src = "script/form/verifyFormGeneral.js";

require_once "views/common/template.view.php";
