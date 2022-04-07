<?php
// appel fichiers constantes URL et ROOT
require_once '../config.php';

require_once(ROOT.'/controllers/Controller.php');
$controller = new Controller();


if(isset($_POST['search'])){
    $recherche = $_POST['search'];
    $formations = $controller-> ajaxSearchFormation($recherche);

    if(empty($formations)){ ?>
        <p class="welcome-text py-4">Il n'y a pas de formation pour ce mot clef.</p>
    <?php } ?>

        <form action="" method="POST" id="enfant">
            <input type="hidden" name="back" value="back">
            <button id="enfant" class="btn button-form" type="submit">Retour</button>
        </form>
  
  <?php foreach($formations as $formation) : ?>
  <div id="box-container-card" class="d-flex flex-column align-items-center">
    <div class="card-box" class="d-flex flex-column align-items-center">

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
    </div>
  </div>
  <?php endforeach ; ?>
<?php } ?>

<?php 
if(isset($_POST['back'])){ 
  $formations = $controller-> ajaxLastFormations();
?>
 <?php foreach($formations as $formation) : ?>     
      <div id="box-container-card" class="d-flex flex-column align-items-center">
          <div class="card-box">
  
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
  
          </div>
      </div>
  <?php endforeach ; ?>

<?php } ?>