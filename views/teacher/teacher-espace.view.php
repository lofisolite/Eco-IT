<?php
ob_start();
?>
  <main>
      <div class="container-intro-espace">
        <h2>Mes formations</h2>
          <p class="welcome-text"><?= 'Bonjour '.$_SESSION['fn'] ?></p>
          <div class="text-explication">
              <p class="text-align">Lorsque vous créez une formation, elle est hors ligne.</p>
              <p class="text-align"> Avant de la mettre en ligne, vous pouvez voir votre formation comme elle sera présentée pour les apprenants et la modifier si besoin puis la mettre en ligne. Elle apparaîtra alors dans le repertoire des formations.</p>
              <p class="text-align">Une fois en ligne, Vous ne pourrez plus modifier votre formation sans l'accord de l'administrateur.</p>
              <div class="d-flex justify-content-center m-3">
                  <a href="<?= URL?>teacherEspace/createFormation" class="btn button-general button-type-2">Créer une formation</a>
              </div>
      </div>

      <div class="container-main">
        <h3>Formations hors ligne</h3>

        <?php if(!empty($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
            <p><?= $_SESSION['alert']['msg'] ?></p>
            </div>
        <?php unset($_SESSION['alert']);
        endif; ?>

        <div class="container-cards" class="d-flex justify-content-center">
          
              <?php if(!isset($formationsNotOnline)){ ?>
              <div class="box-welcome-text">
                  <p class="welcome-text">Vous n'avez pas de formations hors ligne.</p>
              </div>
              <?php } else { ?>
      
                      <?php foreach($formationsNotOnline as $formation) { ?>
                      <div class="card-box d-flex flex-column align-items-center">

                          <div class="card-box-intro">
                            <h4><?= $formation->getTitle();?></h4>
                          </div>

                          <div class="card-box-main">
                            <div class="card-box-image">
                              <div class="card-img">
                                <img src="<?= $formation->getPicture();?>" class="card-img">
                              </div>
                              <p class="card-description"><?= $formation->getDescription();?></p>
                            </div>
                          </div>

                          <div class="card-box-footer formation-buttons-teacher">
                            <div class="box-buttons-teacher">
                                <a class="btn button-general button-type-2 align-self-center"href="<?= URL ?>teacherEspace/formation/<?= $formation->getId() ?>" >Voir</a>
                                  
                                <a href="<?= URL?>teacherEspace/modify/<?= $formation->getId() ?>"class="btn button-general btn-choice-valid align-self-center">Modifier</a>

                                <form style="    margin-block-end: 0em;" method="POST" action="<?= URL ?>teacherEspace/delete/<?= $formation->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer votre formation ?');">
                                    <button type="submit" class="btn button-general btn-choice-reject">Supprimer</button>
                                </form>
                            </div>
                            <div class="box-buttons-teacher">
                              <form method="POST" class="align-self-center" action="<?= URL ?>teacherEspace/online/<?= $formation->getId(); ?>" onSubmit="return confirm('voulez vous vraiment mettre en ligne votre formation ?');">
                                  <button type="submit" class="btn button-general button-type-2">Mettre en ligne</button>
                              </form>
                            </div>
                          </div>
                      </div>
                      <?php } ?>
               
          <?php } ?>
        </div>

        <h3>Formations en ligne</h3>

        <div class="container-cards" class="d-flex justify-content-center">
          
          <?php if(!isset($formationsOnline)){ ?>
              <div class="box-welcome-text">
                  <p class="welcome-text">Vous n'avez pas de formations en ligne.</p>
              </div>
          <?php } else { ?>

            <?php foreach($formationsOnline as $formation) { ?>
              
                <div class="card-box d-flex flex-column align-items-center">

                  <div class="card-box-intro">
                    <h4><?= $formation->getTitle();?></h4>
                  </div>

                  <div class="card-box-main">
                    <div class="card-box-image">
                      <div class="card-img">
                        <img src="<?= $formation->getPicture();?>" alt="logo javascript" class="card-img">
                      </div>
                      <p class="card-description"><?= $formation->getDescription();?></p>
                    </div>
                  </div>

                  <div class="card-box-footer formation-buttons-teacher">
                      <div class="box-buttons-teacher">
                          <a href="<?= URL ?>teacherEspace/formation/<?= $formation->getId() ?>" class="btn button-general button-type-2 align-self-center">Voir la formation</a>
                      </div>
                  </div>
    
                </div>
              
            <?php } ?>
          <?php } ?>
          
        </div>
    </div>
  </main>


<?php

$content = ob_get_clean();
$titleHead = 'Espace formateur';

$src = 'script/ajax/ajax.js';

require "views/common/template.view.php";