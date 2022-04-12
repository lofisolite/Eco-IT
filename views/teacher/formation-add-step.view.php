<?php
ob_start();
?>

    <main class="mt-4" id="formation-creation">
        <h2>Création de la section 1</h2>

        <div class="text-explication">  
        </div>
     
        <h2>titre section 1</h2>
        <p>Chaque section doit contenir au moins deux leçons.</p>
        <p>Une leçon contient un titre, un vidéo youtube, un contenu textuel et éventuellement des ressources</p>
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
                    <p id="errorLessonVideo1" class="mb-3 error-msg"></p>
                    <label for="lessonVideo1" class="form-label">Vidéo youtube</label>
                    <p class="explication-msg mb-2"></p>
                    <input type="text" class="form-control" id="lessonVideo1" name="lessonVideo1" value="" minlength="10" maxlength="200" required>
                </div>

                <div class="mb-3">
                    <p id="errorLessonContent1" class="mb-3 error-msg"></p>
                    <label for="lessonContent1" class="form-label">Contenu</label>
                    <textarea class="form-control" id="lessonContent1" name="lessonContent1" value="" cols="30" rows="10" min="2" max="" required></textarea>
                </div>

                <h3 style='display:none' id="resourceTitle">Ressources</h3>
                
                <div class="mb-3" id="divResource"  style='display:none'>

                  
                  
                </div>

                
                <div class="d-flex justify-content-center">
                  <a class="btn button-general btn-choice-valid" id="buttonAddResource">Ajouter ressource</a>
                  <a class="btn button-general btn-choice-reject" id="buttonDeleteResource">Supprimer ressource</a>
                </div>


                <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
          </form>
        </div>
    </main>

<?php

$content = ob_get_clean();

$titleHead = 'Ajout Formation';
$src = "script/form/formAddFormation.js";

require "views/common/template.view.php";