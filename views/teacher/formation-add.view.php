<?php
ob_start();
?>

    <main id="main-inscription">
        <h2>Créer votre formation</h2>

        <div class="text-explication">  
        </div>
        <?php if(isset($_POST['order[]'])){
          echo $_POST['order[]'];
        } ?>
          
        <div class="d-flex justify-content-center" >
            <form action="?step=1" id="step1" enctype="multipart/form-data" method="POST" class="form d-flex flex-column" id="formAddFormation">
                <h3>Général</h3>
                <p id="errorMsg1" class="mb-3 error-msg"></p>

                <div class="mb-3">
                    <p id="errorFormationTitle" class="mb-3 error-msg"></p>
                    <label for="formationTitle" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="formationTitle" name="formationTitle" value="" minlength="2" maxlength="80" required>
                </div>

                <div class="mb-3">
                    <p id="errorformationDescription" class="mb-3 error-msg"></p>
                    <label for="formationDescription" class="form-label">Description</label>
                    <p class="explication-msg mb-2">Maximum 500 caractères, n'hésitez pas à mettre des mot clefs.</p>
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
                <div class="mb-3" id="containerSectionInput">
                    <p id="errorSectionTitle" class="mb-3 error-msg"></p>

                    <label for="sectionTitle1" class="form-label labelSection">Section 1 - titre</label>
                    <input type="hidden" value="1" name="sectionOrder[]" class="inputOrderSection">
                    <input type="text" class="form-control" id="sectionTitle1" name="sectionTitle[]" value="" minlength="2" maxlength="60" required>

                    <label for="sectionTitle2" class="form-label mt-2">Section 2 - titre</label>
                    <input type="hidden" value="2" name="sectionOrder[]" class="inputOrderSection">
                    <input type="text" class="form-control" id="sectionTitle2" name="sectionTitle[]" value="" minlength="2" maxlength="60" required>
                </div>
                <div class="d-flex justify-content-center">
                  <a class="btn btn-form-input btn-choice-valid" id="buttonAddInputSection">Ajout section</a>
                  <a class="btn btn-form-input btn-choice-reject" id="buttonDeleteInputSection">Supprimer section</a>
                </div>

                <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
            </form>
        </div>




        <h2>Section 1 : + titre</h2>
        <div class="d-flex justify-content-center">
          <form action="?step=1" id="" enctype="multipart/form-data" method="POST" class="form d-flex flex-column" id="formAddFormation">
                <h3>Leçon 1</h3>
                <p id="errorMsg" class="mb-3 error-msg"></p>

                <div class="mb-3">
                    <p id="errorLessonTitle1" class="mb-3 error-msg"></p>
                    <label for="lessonTitle1" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="lessonTitle1" name="lessontitle1" value="" minlength="2" maxlength="60" required>
                </div>

                <div class="mb-3">
                    <p id="errorLessonContent1" class="mb-3 error-msg"></p>
                    <label for="lessonContent1" class="form-label">Contenu</label>
                    <textarea class="form-control" id="lessonContent1" name="lessonContent1" value="" cols="30" rows="10" min="2" max="" required></textarea>
                </div>

                <div class="mb-3">
                    <p id="errorLessonVideo1" class="mb-3 error-msg"></p>
                    <label for="lessonVideo1" class="form-label">Vidéo youtube</label>
                    <p class="explication-msg mb-2"></p>
                    <input type="text" class="form-control" id="lessonVideo1" name="lessonVideo1" value="" minlength="10" maxlength="200" required>
                </div>

                <h3 style='display:none' id="resourceTitleh3">Ressources</h3>
                
                <div class="mb-3" id="divResource"  style='display:none'>

                  
                  
                </div>

                
                <div class="d-flex justify-content-center">
                  <a class="btn btn-form-input btn-choice-valid" id="buttonAddResource">Ajouter ressource</a>
                  <a class="btn btn-form-input btn-choice-reject" id="buttonDeleteResource">Supprimer ressource</a>
                </div>


                <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
          </form>
        </div>
    </main>

<?php

$content = ob_get_clean();

require "views/common/template.view.php";