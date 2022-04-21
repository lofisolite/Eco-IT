<?php
ob_start();

?>

    <main class="mt-4" id="formation-creation">
        <h2>Créer votre formation</h2>

        <div class="text-explication">  
        </div>
        <div class="d-flex justify-content-center" >
            <form action="" method="POST" enctype="multipart/form-data" class="form d-flex flex-column" id="formAddFormation">
                <h3>Eléments généraux</h3>
                <p>Une formation doit avoir un <span>titre</span>, une <span>description</span> et une <span>image</span>, ces éléments apparaitront directement dans le répertoire des formations.</p>
                <?php if(isset($error)) : ?>
                    <p id="errorMsg" class="mb-3 error-msg"><?= $error ?></p>
                <?php endif; ?>

                <div class="mb-3">
                <?php if(isset($errorTitle)) : ?>
                    <p id="errorFormationTitle" class="mb-3 error-msg"><?= $errorTitle ?></p>
                <?php endif; ?>
                    <label for="formationTitle" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="formationTitle" name="formationTitle" value="<?= $_POST['formationTitle'] ?? '' ?>" minlength="2" maxlength="70" required>
                </div>

                <div class="mb-3">
                <?php if(isset($errorDescription)) : ?>
                    <p id="errorFormationDescription" class="mb-3 error-msg"><?= $errorDescription ?></p>
                <?php endif;  ?>
                    <label for="formationDescription" class="form-label">Description</label>
                    <p class="explication-msg mb-2">Maximum 500 caractères, n'hésitez pas à mettre des mots clefs liés aux sujet de votre formation, de cette façon elle pourra être recherché plus facilement par les étudiants.</p>
                    <textarea class="form-control" id="formationDescription" name="formationDescription" value="" cols="30" rows="6" min="2" max="500" required><?= $_POST['formationDescription'] ?? '' ?></textarea>
                    <div id="compteur1" style="text-align:right">0</div>
                </div>

                <div class="mb-3">
                <?php if(isset($errorPicture)) : ?>
                    <p id="errorFormationPicture" class="mb-3 error-msg"><?=  $errorPicture ?></p>
                <?php endif;  ?>
                    <label for="formationPicture" class="form-label">Image</label>
                    <p class="explication-msg mb-2">Formats acceptés : JPG/JPEG, PNG. 2MO maximum.</p>
                    <input type="file" class="form-control" id="formationPicture" name="formationPicture" accept="image/png, image/jpeg" required>
                </div>

                <h3 class="mt-2">Sections</h3>
                <p>Il est conseillé d'avoir au moins deux sections</p>

                <div class="mb-3" id="containerSections">
                <?php if(isset($errorSection)) : ?>
                    <p id="errorFormationSection" class="mb-3 error-msg"><?=  $errorSection ?></p>
                <?php endif;  ?>
                    <div id="containerSection1">
                        <h4 class="my-4 text-center" id="nbrSection1">Section 1</h4>
                        <p id="errorSectionTitle1" class="mb-3 error-msg"></p>
                        <label for="sectionTitle1" class="form-label labelSection">Section 1 - titre :</label>
                        <input type="hidden" value="1" name="sectionOrder[]" class="inputOrderSection">
                        <input type="text" id="sectionTitle1" class="form-control sectionTitleClass" name="sectionTitle[]" value="<?= $_POST['sectionTitle'][0] ?? '' ?>" minlength="2" maxlength="70" required>

                        <label for="nbrLesson1" class="my-2">Nombre de lesson :</label>
                        <select name="nbrLesson[]" id="nbrLesson1" class="nbrLesson" required>
                            <option value="" ></option>
                            <?php for($i = 1; $i<=10; $i++){ ?>
                            <option value="<?= $i ?>"
                            <?php if(isset($_POST['nbrLesson'][0])){
                                    if($_POST['nbrLesson'][0] === $i){
                                        echo "selected";
                                    }
                                } ?>><?= $i ?>
                                </option>
                            <?php } ?>
                            </select>
                    </div>
                    
                    <?php if(isset($contentSectionTitle)){
                        echo $contentSectionTitle;
                    } ?>
                </div>
                <div class="d-flex justify-content-center">
                  <a class="btn button-general btn-choice-valid" id="addSection">+ section</a>
                  <a class="btn button-general btn-choice-reject" id="deleteSection">- section</a>
                </div>

                <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
            </form>
        </div>
    </main>

<?php

$content = ob_get_clean();

$titleHead = 'Ajout formation';
$src = "script/form/addFormation/verifyAddFormFormation.js";
$src2 = "script/form/addFormation/addFormation.js";

require "views/common/template.view.php";