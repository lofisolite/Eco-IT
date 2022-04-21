<?php
ob_start();
?>
<main>
    <div class="container-intro-espace" class="d-flex flex-column align-items-center">
        <h2>Les formations</h2>
        <p class="welcome-text"><?= 'Bonjour '.$_SESSION['ps'] ?></p>
        <div class="text-explication">
            <p class="text-center">L'onglet "Les dernières" présente les dernières formations sorties, vous pouvez également chercher une formation par mot clef.</p>
            <p class="text-center">Lorsque vous cliquez sur "accéder", la formation sera placé dans l'onglet "En cours".</p>
            <p class="text-center">En validant toutes les leçons d'une formation, elle se retrouvera dans l'onglet "terminées".</p>
        </div>

          <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
              <a class="nav-link active" data-bs-toggle="tab" href="#toutes">Les dernières</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#en-cours">En cours</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#termine">Terminées</a>
            </li>
          </ul>
    </div>

    <div class="container-main">
        <div id="myTabContent" class="tab-content">
  
            <div class="tab-pane fade  active show" id="toutes">
                <h3>Les dernières formations</h3>

                <div class="container-cards">
                    <div id="container-card">
                        <div id="container-form-home" class="d-flex flex-column align-items-start">
                            <div id="box-search-form">
                                <form action="" method="POST" id="form-search-student">
                                    <label for="input-search" class="form-label">Chercher une formation :</label>
                                    <br>
                                    <input type="hidden" name="st" value="st">
                                    <input type="text" id="input-search" name="search" placeholder="ex : javascript, front-end..." minlength="2" maxlength="30" required>
                                    <button class="btn button-form-search" type="submit">Envoi</button>
                                </form>
                            </div>
                        </div>



                        <div id="resultat">
                        <?php foreach($lastFormationsTable as $formation) : ?>
                            <div class="d-flex flex-column align-items-center">
                                <div class="card-box d-flex flex-column align-items-center">
                                    <div class="card-box-intro">
                                        <h4><?= $formation['title']; ?></h4>
                                    </div>

                                    <div class="card-box-main">
                                        <div class="card-box-image">
                                        <div class="card-img">
                                            <img src="<?= $formation['picture']?>" class="card-img">
                                        </div>
                                        <p class="card-description"><?= $formation['description']?></p>
                                        </div>
                                    </div>

                                    <div class="card-box-footer">
                                        <p class="text-center"><span>Formateur : </span><?= $formation['firstname'] .' '. $formation['lastname'] ?></p>
                                    </div>

                                    <a href="<?= URL ?>studentEspace/formation/<?= $formation['id'] ?>" class="btn button-general button-type-2 m-3">Accéder</a>
                                </div>
                            </div>
                        <?php endforeach ; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="en-cours">
                <h3>Mes formations en cours</h3>
                <div class="container-cards">
                    <div id="container-card">
                    <?php if(!empty($startedFormationsTable)){
                        foreach($startedFormationsTable as $formation) : ?>
                        <div class="d-flex flex-column align-items-center">

                            <div class="card-box  d-flex flex-column align-items-center">
                                <div class="card-box-intro">
                                    <h4><?= $formation['title'] ?></h4>
                                </div>

                                <div class="card-box-main">
                                    <div class="card-box-image">
                                    <div class="card-img">
                                        <img src="<?= $formation['picture'] ?>" alt="logo javascript" class="card-img">
                                    </div>
                                        <p class="card-description"><?= $formation['description'] ?></p>
                                    </div>
                                </div>

                                <div class="card-box-footer">
                                    <p class="text-center"><span>Formateur : </span><?= $formation['firstname'].' '.$formation['lastname'] ?></p>
                                    <p class="text-center"><span>Ma progression : </span><?= $formation['progression'].'%' ?></p>
                                </div>

                                <a href="<?= URL ?>studentEspace/formation/<?= $formation['id'] ?>" class="m-3 btn button-general button-type-2">Accéder</a>
                            </div>
                        </div>
                     <?php endforeach ; 
                     } else {?>
                     <div class="box-welcome-text">
                        <p class="welcome-text">Vous n'avez pas de formations en cours</p>
                     </div>
                     <?php } ?>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="termine">
                <h3>Mes formations terminées</h3>
                <div class="container-cards" class="d-flex justify-content-center">
                    <div id="container-card">
                    <?php if(!empty($finishedFormationsTable)){    
                        foreach($finishedFormationsTable as $formation) : ?>
                        <div class="d-flex flex-column align-items-center">
                        
                            <div class="card-box d-flex flex-column align-items-center">
                                <div class="card-box-intro">
                                    <h4><?= $formation['title'] ?></h4>
                                </div>

                                <div class="card-box-main">
                                    <div class="card-box-image">
                                    <div class="card-img">
                                        <img src="<?= $formation['picture'] ?>" alt="logo javascript" class="card-img">
                                    </div>
                                    <p class="card-description"><?= $formation['description'] ?></p>
                                    </div>
                                </div>

                                <div class="card-box-footer">
                                    <p class="text-center"><span>Formateur : </span><?= $formation['firstname'].' '. $formation['lastname'] ?></p>
                                    <p class="text-center"><span>Ma progression : </span> 100%</p>
                                </div>
                        
                                <a href="<?= URL ?>studentEspace/formation/<?= $formation['id']?>" class="btn button-general button-type-2 m-3">Accéder</a>
                            </div>
                        </div>
                        <?php endforeach ;
                        } else {?>
                        <div class="box-welcome-text">
                            <p class="welcome-text">Vous n'avez pas de formations terminées.</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>


<?php
$content = ob_get_clean();

$titleHead = 'Espace étudiant';
//$src = '';
$src = 'script/ajax/ajax.js';

require "views/common/template.view.php";
