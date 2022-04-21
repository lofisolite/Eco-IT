<?php
ob_start();

?>

    <main class="mt-4" id="formation-creation">
        <h2>Section<?=' '.$step ?></h2>
        <h3><?= $sectionTitle ?></h3>
        <div class="text-explication">
            <p>Une leçon contient un <span>titre</span>, une <span>vidéo youtube</span> et un <span>contenu textuel.</span></p> 
        </div>

        <div class="d-flex justify-content-center">
          <form action="" id="formAddFormationStep" method="POST" class="form d-flex flex-column">
          <?php if(isset($error)) : ?>
                <p id="errorMsg" class="mb-3 error-msg"><?= $error ?></p>
            <?php endif; ?>

            <?php for($i= 1; $i <= $numberLesson; $i++){ ?>
                <h3>Leçon <?= $i ?></h3>

                <div class="mb-3">
                    <p id="errorLessonTitle<?= $i ?>" class="mb-3 error-msg errorLessonTitle"><?php if(isset($errorTitleLesson[$i-1])){ echo $errorTitleLesson[$i-1]; }?></p>
                    <label for="lessonTitle<?= $i ?>" class="form-label">Titre</label>
                    <input type="hidden" value="<?= $i ?>" name="lessonOrder[]" class="inputOrderLesson">
                    <input type="text" class="form-control lessonTitleClass" id="lessonTitle<?= $i ?>" name="lessonTitle[]" value="<?= $_POST['lessonTitle'][$i-1] ?? '' ?>" minlength="2" maxlength="70" required>
                </div>

                <div class="mb-3">
                    <p id="errorLessonVideo<?= $i ?>" class="mb-3 error-msg errorLessonVideo"><?php if(isset($errorVideoLesson[$i-1])){ echo $errorVideoLesson[$i-1]; }?></p>
                    <label for="lessonVideo<?= $i ?>" class="form-label errorLessonVideo">Vidéo youtube</label>
                    <p class="explication-msg mb-2"></p>
                    <input type="text" class="form-control lessonVideoClass" id="lessonVideo<?= $i ?>" name="lessonVideo[]" value="<?= $_POST['lessonVideo'][$i-1] ?? '' ?>" minlength="10" maxlength="200" required>
                </div>

                <div class="mb-3">
                    <p id="errorLessonContent<?= $i ?>" class="mb-3 error-msg errorLessonContent"><?php if(isset($errorContentLesson[$i-1])){ echo $errorContentLesson[$i-1]; }?></p>
                    <label for="lessonContent<?= $i ?>" class="form-label">Contenu</label>
                    <textarea class="form-control lessonContentClass" id="lessonContent<?= $i ?>" name="lessonContent[]" value="" cols="30" rows="10" min="50" max="20000" required><?= $_POST['lessonContent'][$i-1] ?? '' ?></textarea>
                </div>
                <hr class="my-5">

            <?php } ?>

                <button type="submit" class="my-3 btn button-general button-type-2 align-self-center">Valider</Button>
          </form>
        </div>
    </main>

<?php

$content = ob_get_clean();

$titleHead = 'Ajout Formation - étape '.$step;
$src = "script/form/addFormation/verifyAddFormFormationStep.js";
require "views/common/template.view.php";