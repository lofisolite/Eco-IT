<?php
ob_start();

?>

    <main class="mt-4" id="formation-creation">
    <a href="<?= URL ?>teacherEspace/modify/<?= $formation->getId(); ?>" class="btn button-general button-type-1">Retour</a>
        <h2>Modifier les éléments généraux</h2>

        <div class="text-explication">  
        </div>
        <div class="d-flex justify-content-center" >
            <form action="" method="POST" enctype="multipart/form-data" class="form d-flex flex-column" id="formAddFormation">
                <p>Une formation doit avoir un <span>titre</span>, une <span>description</span> et une <span>image</span>, ces éléments apparaitront directement dans le répertoire des formations.</p>
                <?php if(isset($error)) : ?>
                    <p id="errorMsg" class="mb-3 error-msg"><?= $error ?></p>
                <?php endif; ?>

                <div class="mb-3">
                <?php if(isset($errorTitle)) : ?>
                    <p id="errorFormationTitle" class="mb-3 error-msg"><?= $errorTitle ?></p>
                <?php endif; ?>
                    <label for="formationTitle" class="form-label">Titre</label>
                    <input type="hidden" name="envoi" value="envoi">
                    <input type="text" class="form-control" id="formationTitle" name="formationTitle" value="<?= $_POST['formationTitle'] ?? $formation->getTitle(); ?>" minlength="2" maxlength="70" required>
                </div>

                <div class="mb-3">
                <?php if(isset($errorDescription)) : ?>
                    <p id="errorFormationDescription" class="mb-3 error-msg"><?= $errorDescription ?></p>
                <?php endif;  ?>
                    <label for="formationDescription" class="form-label">Description</label>
                    <p class="explication-msg mb-2">Maximum 500 caractères, n'hésitez pas à mettre des mots clefs liés aux sujet de votre formation, de cette façon elle pourra être recherché plus facilement par les étudiants.</p>
                    <textarea class="form-control" id="formationDescription" name="formationDescription" value="" cols="30" rows="6" min="2" max="500" required><?= $_POST['formationDescription'] ?? $formation->getDescription(); ?></textarea>
                    <div id="compteur1" style="text-align:right">0</div>
                </div>

                <div class="mb-3">
                <?php if(isset($errorPicture)) : ?>
                    <p id="errorFormationPicture" class="mb-3 error-msg"><?=  $errorPicture ?></p>
                <?php endif;  ?>
                    <p class="fw-bold">Image actuelle</p><br>
                    <div class="card-box-main"> 
                    <img src="<?= URL.$formation->getPicture();?>" class="card-img-form">
                    </div>
                    <br>
                    <label for="formationPicture" class="form-label">Changer l'image</label>
                    <p class="explication-msg mb-2">Formats acceptés : JPG/JPEG, PNG. 2MO maximum.</p>
                    <input type="file" class="form-control" id="formationPicture" name="formationPicture" accept="image/png, image/jpeg">
                </div>

                <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
            </form>
        </div>
    </main>

<?php

$content = ob_get_clean();

$titleHead = 'Ajout formation';
$src = "script/form/modifyFormation/verifyGeneralFormFormation.js";

require "views/common/template.view.php";