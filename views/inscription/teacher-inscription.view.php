<?php
ob_start();
?>

<main id="main-inscription">
    <h2>Inscription formateur</h2>

    <div class="text-explication">
        <p class="text-align">Une fois inscrit, nous vous contacterons pour un entretien.</p>  
    </div>

    <div class="d-flex justify-content-center" >
        <form action="" enctype="multipart/form-data" method="POST" class="form d-flex flex-column" id="formTinscription">
            <?php if(isset($error)) : ?>
            <p id="errorMsg" class="mb-3 error-msg"><?= $error ?></p>
            <?php endif ?>

            <div class="mb-3">
                <p id="errorFirstname" class="mb-3 error-msg"></p>
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $_POST['firstname'] ?? '' ?>" minlength="2" maxlength="50" required>
            </div>

            <div class="mb-3">
                <p id="errorLastname" class="mb-3 error-msg"></p>
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $_POST['lastname'] ?? '' ?>" minlength="2" maxlength="50" required>
            </div>

            <div class="mb-3">
                <p id="errorPictureProfile" class="mb-3 error-msg"></p>
                <label for="pictureProfile" class="form-label">Photo de profil</label>
                <p class="explication-msg mb-3">Formats acceptés : JPG/JPEG, PNG. Max 1MO.</p>
                <input type="file" class="form-control" id="pictureProfile" value="<?= $_FILES['pictureProfile'] ?? '' ?>" name="pictureProfile" accept="image/png, image/jpeg" required >
            </div>

            <div class="mb-3">
                <p id="errorDescription" class="mb-3 error-msg"></p>
                <label for="description" class="form-label">Décrivez vous</label>
                <p class="explication-msg mb-3">Maximum 500 caractères sur votre parcours et vos spécialités.</p>
                <textarea class="form-control" id="description" name="description" cols="30" rows="6" minlength="2" maxlength="500" required><?= $_POST['description'] ?? '' ?></textarea>
                <div id="compteur" style="text-align:right">0</div>
            </div>
            <script>
                document.getElementById('description').addEventListener('keyup', function() {
                    document.getElementById('compteur').innerHTML = document.getElementById('description').value.length;
                });
            </script>

            <div class="mb-3">
                <p id="errorMail" class="mb-3 error-msg"></p>
                <label for="mail" class="form-label">Adresse mail</label>
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

$titleHead = 'inscription formateur';
//$src = '';
$src = "script/form/verifyFormGeneral.js";

require_once "views/common/template.view.php";