<?php
ob_start();
?>

    <main class="mt-4" id="formation-creation">
        <h2>Créer votre formation</h2>

        <div class="text-explication">  
        </div>
          
        <div class="d-flex justify-content-center" >
            <form action="?step=1" id="step1" enctype="multipart/form-data" method="POST" class="form d-flex flex-column" id="formAddFormation">
                <h3>Eléments généraux</h3>
                <p>Une formation doit avoir un <span>titre</span>, une <span>description</span> et une </span>image</span>, ces éléments apparaitront directement dans le répertoire des formations.</p>
                <p id="errorMsg1" class="mb-3 error-msg"></p>

                <div class="mb-3">
                    <p id="errorFormationTitle" class="mb-3 error-msg"></p>
                    <label for="formationTitle" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="formationTitle" name="formationTitle" value="" minlength="2" maxlength="80" required>
                </div>

                <div class="mb-3">
                    <p id="errorformationDescription" class="mb-3 error-msg"></p>
                    <label for="formationDescription" class="form-label">Description</label>
                    <p class="explication-msg mb-2">Maximum 500 caractères, n'hésitez pas à mettre des mots clefs liés aux sujet de votre formation, de cette façon elle pourra être recherché plus facilement par les étudiants</p>
                    <textarea class="form-control" id="formationDescription" name="formationDescription" value="" cols="30" rows="6" min="2" max="500" required></textarea>
                    <div id="compteur1" style="text-align:right">0</div>
                </div>

                <div class="mb-3">
                    <p id="errorFormationPicture" class="mb-3 error-msg"></p>
                    <label for="formationPicture" class="form-label">Image</label>
                    <p class="explication-msg mb-2">Formats acceptés : JPG/JPEG, PNG.</p>
                    <input type="file" class="form-control" id="formationPicture" name="formationPicture" accept="image/png, image/jpeg" required>
                </div>

                <h3 class="mt-2">Sections</h3>
                <div class="mb-3" id="containerSection">
                    <p id="errorSectionTitle" class="mb-3 error-msg"></p>

                    <label for="sectionTitle1" class="form-label labelSection">Section 1 - titre</label>
                    <input type="hidden" value="1" name="sectionOrder[]" class="inputOrderSection">
                    <input type="text" class="form-control" id="sectionTitle1" name="sectionTitle[]" value="" minlength="2" maxlength="60" required>

                    <label for="sectionTitle2" class="form-label mt-2">Section 2 - titre</label>
                    <input type="hidden" value="2" name="sectionOrder[]" class="inputOrderSection">
                    <input type="text" class="form-control" id="sectionTitle2" name="sectionTitle[]" value="" minlength="2" maxlength="60" required>
                </div>
                <div class="d-flex justify-content-center">
                  <a class="btn button-general btn-choice-valid" id="addSection">Ajout section</a>
                  <a class="btn button-general btn-choice-reject" id="deleteSection">Supprimer section</a>
                </div>
                <div id="try"></div>

                <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
            </form>
        </div>
    </main>

<?php

$content = ob_get_clean();

$titleHead = 'Ajout formation';
$src = "script/form/verifyFormFormation.js";

require "views/common/template.view.php";