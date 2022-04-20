<?php
// appel fichiers constantes URL et ROOT
require_once '../config.php';
require_once(ROOT.'/controllers/security.php');

require_once(ROOT.'/controllers/Controller.php');
$controller = new Controller();

// student et visiteur : recherche formation par mot clef
if(isset($_POST['search'])){
    $recherche = secureData($_POST['search']);
    $formations = $controller-> ajaxSearchFormation($recherche);

    if(empty($formations)){ ?>
        <p class="welcome-text py-4">Il n'y a pas de formation pour ce mot clef.</p>
    <?php } 

        if(isset($_POST['st'])){ ?>
        <form action="" method="POST" id="enfant">
            <input type="hidden" name="student" value="student">
            <input type="hidden" name="back" value="back">
            <button class="btn button-form-search" type="submit">Retour</button>
        </form>
          
      <?php } else { ?>
        <form action="" method="POST" id="enfant">
            <input type="hidden" name="back" value="back">
            <button id="enfant" class="btn button-form-search" type="submit">Retour</button>
        </form>

        <?php } 
        

    foreach($formations as $formation) : ?>
  <div class="d-flex flex-column align-items-center">
      <div class="card-box d-flex flex-column align-items-center">

          <div class="card-box-intro">
              <h4><?= $formation['title']; ?></h4>
          </div>

          <div class="card-box-main">
              <div class="card-box-image">
                  <div class="card-img">
                      <img src="<?= $formation['picture']?>" alt="logo javascript" class="card-img">
                  </div>
                  <p class="card-description"><?= $formation['description']?></p>
              </div>
          </div>

          <div class="card-box-footer">
              <p class="text-center"><span>Formateur : </span><?= $formation['firstname'] .' '. $formation['lastname'] ?></p>
          </div>

          <?php if(isset($_POST['st'])){ ?>
              <a href="studentEspace/formation/<?= $formation['id'] ?>" class="btn button-general button-type-2 m-3">Accéder</a>
          <?php } ?>
      </div>
  </div>
  <?php endforeach ; 
   } 

// student et visiteur : bouton retour aux dernière formations
if(isset($_POST['back'])){ 
  $formations = $controller-> ajaxLastFormations();
?>
 <?php foreach($formations as $formation) : ?>     
      <div class="d-flex flex-column align-items-center">
          <div class="card-box d-flex flex-column align-items-center">
  
              <div class="card-box-intro">
                  <h4><?= $formation['title']; ?></h4>
              </div>
  
              <div class="card-box-main">
                  <div class="card-box-image">
                      <div class="card-img">
                          <img src="<?= $formation['picture']?>" alt="logo javascript" class="card-img">
                      </div>
                      <p class="card-description"><?= $formation['description']?></p>
                  </div>
              </div>
  
              <div class="card-box-footer">
                  <p class="text-center"><span>Formateur : </span><?= $formation['firstname'] .' '. $formation['lastname'] ?></p>
              </div>
              <?php if(isset($_POST['student'])){ ?>
                  <a href="studentEspace/formation/<?= $formation['id']?>" class="btn button-general button-type-2 m-3">Accéder</a>
              <?php } ?>
          </div>
      </div>
  <?php endforeach ; 
} 

// student : mise à jour lesson "en cours"
if(isset($_POST['lessonInProgress'])){
    $studentId = $_POST['stId'];
    $lessonId = $_POST['lsId'];
    $formationId = $_POST['fmId'];
    $status = 'en cours';

    $controller->ajaxUpdateLessonAndFormationStatus($studentId, $lessonId, $formationId, $status);

    $statusString = array("status"=> $status);
    echo json_encode($statusString);
    
 } 

// student : mise à jour lesson "terminé"
if(isset($_POST['lessonFinished'])){ 
    $studentId = $_POST['stId'];
    $lessonId = $_POST['lsId'];
    $formationId = $_POST['fmId'];
    $status = 'terminé';

    $controller->ajaxUpdateLessonAndFormationStatus($studentId, $lessonId, $formationId, $status);

    $statusString = array("status"=> $status);
    echo json_encode($statusString);

} ?>


<?php // essai ajout input section
/*
if(isset($_POST['addSection'])){
    $sectionAdd = $_POST['addSection'];
?>

<div id="containerSection<?= $sectionAdd ?>">
    <p id="errorSectionTitle<?= $sectionAdd ?>" class="mb-3 error-msg"></p>
    <label for="sectionTitle<?= $sectionAdd ?>" class="form-label labelSection">Section <?= $sectionAdd ?> - titre :</label>
    <input type="hidden" value="<?= $sectionAdd ?>" name="sectionOrder[]" class="inputOrderSection">
    <input type="text" id="sectionTitle<?= $sectionAdd ?>" class="form-control sectionTitleClass" name="sectionTitle[]" value="" minlength="2" maxlength="70" required>
</div>
} ?>
*/


