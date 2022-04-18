<?php
ob_start();
?>

<main>

<?php if(!empty($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
            <p><?= $_SESSION['alert']['msg'] ?></p>
            </div>
        <?php unset($_SESSION['alert']);
        endif; ?>


      <section id="container-intro-home" class="d-flex flex-column align-items-center">
          <h2>Formations en eco-conception web</h2>
          <p class="m-2">La crise écologique est aujourd'hui une réalité, en matière d'émissions de CO2, des études montrent qu'internet pollue 1.5 fois plus que le transport aérien. Des solutions existent pour limiter notre impact sur le réchauffement climatique, EcoIT est un organisme de formation fondé en 2017 et dont l'objectif est d'éduquer à l'éco-conception web.</p>
          <br>
          <p class="fw-bold">Pour accéder à nos formations, il suffit de s'inscrire.</p>
          <a href="<?= URL ?>Sinscription" type="button" class="btn button-general button-type-1">S'inscrire</a>
          <p class="fw-bold my-4">Pour proposer des formations sur l'éco-conception web, vous pouvez postuler.
          </p>
            <a href="<?= URL ?>Tinscription" type="button" class="btn button-general button-type-1">Postuler</a>
      </section>

      <div class="container-main">
        <h3>Nos dernières formations</h3>

        <div class="container-cards" class="d-flex justify-content-center">
            <div id="container-card">
                <div id="container-form-home" class="d-flex flex-column align-items-start">
                
                    <div id="box-search-form">
                      <form action="" method="POST" id="form-search">
                        <label for="input-search" class="form-label">Chercher une formation :</label>
                        <br>
                        <input type="text" id="input-search" name="search" placeholder="ex : javascript, front-end..." minlength="2" maxlength="30" required>
                        <button class="btn button-form-search" type="submit">Envoi</button>
                      </form>
                    </div>
                </div>

                <div id="resultat">
                  <?php foreach($formationsTable as $formation) : ?>
                      
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
                </div>


            </div>
        </div>

      </div>
    </main>

<?php

$content = ob_get_clean();
    
$titleHead = 'accueil EcoIt';

//$src = '';
$src = 'script/ajax/ajax.js';

require "views/common/template.view.php";