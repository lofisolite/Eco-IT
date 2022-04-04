<?php
ob_start();

?>
<main>
      <section id="container-intro-home" class="d-flex flex-column align-items-center">
        <h2>Formations en eco-conception web</h2>
        <p class="m-2">La crise écologique est aujourd'hui une réalité, en matière d'émissions de CO2, des études montrent qu'internet pollue 1.5 fois plus que le transport aérien. Des solutions existent pour limiter notre impact sur le réchauffement climatique, EcoIT est un organisme de formation fondé en 2017 et dont l'objectif est d'éduquer à l'éco-conception web.</p>
        <br>
        <p class="fw-bold">Pour accéder à nos formations, il suffit de s'inscrire.</p>
        <a href="<?=URL ?>Sinscription" type="button" class="btn button-general button-type-1">S'inscrire</a>
        <p class="fw-bold my-4">Pour proposer des formations sur l'éco-conception web, vous pouvez postuler.
        </p>
          <a href="<?=URL ?>Tinscription" type="button" class="btn button-general button-type-1">Postuler</a>
      </section>

      <div class="container-main">
        <h3>Les formations</h3>

        <div class="container-cards" class="d-flex justify-content-center">
          <div id="container-card">
            <div id="container-form-home" class="d-flex flex-column align-items-start">
            
              <div id="box-search-form">
                <form action=""  method="POST" id="form-search">
                  <label for="input-search" class="form-label">Chercher une formation :</label>
                  <br>
                  <input type="text" id="input-search" name="search" placeholder="ex : javascript, front-end...">
                  <button class="btn button-form" type="submit">Envoi</button>
                </form>
              </div>

            </div>

            <div id="card-container" class="d-flex flex-column align-items-center">
              <div class="card-box d-flex flex-column align-items-center">

                <div class="card-box-intro">
                  <h4>L'impact environnemental de la conception de site web sous php et javascript</h4>
                </div>

                <div class="card-box-main">
                  <div class="card-box-image">
                    <div class="card-img">
                      <img src="images/javascript.jpg" alt="logo javascript" class="card-img">
                    </div>
                    <p class="card-description">Cette formation a pour but de vous faire acquérir des bonnes pratiques dans la réalisation d'un site web afin de réduire son impact environnemental. En passant par les phases d'analyses, de maquettage et enfin de réalisation, vous avancerez pas à pas dans la conception de votre site.</p>
                  </div>
                </div>

                <div class="card-box-footer">
                  <p class="text-center"><span>Formateur :</span> Florian Fleur</p>
                </div>

              </div>
            </div>

            <div id="box-container-card" class="d-flex flex-column align-items-center">
              <div class="card-box" class="d-flex flex-column align-items-center">

                <div class="card-box-intro">
                  <h4>L'impact environnemental de la conception de site web sous php et javascript</h4>
                </div>

                <div class="card-box-main">
                  <div class="card-box-image">
                    <div class="card-img">
                      <img src="images/javascript.jpg" alt="logo javascript" class="card-img">
                    </div>
                    <p class="card-description">Cette formation a pour but de vous faire acquérir des bonnes pratiques dans la réalisation d'un site web afin de réduire son impact environnemental. En passant par les phases d'analyses, de maquettage et enfin de réalisation, vous avancerez pas à pas dans la conception de votre site.</p>
                  </div>
                </div>

                <div class="card-box-footer">
                  <p class="text-center"><span>Formateur :</span> Florian Fleur</p>
                </div>

              </div>
            </div>

            <div id="box-container-card" class="d-flex flex-column align-items-center">
              <div class="card-box" class="d-flex flex-column align-items-center">

                <div class="card-box-intro">
                  <h4>L'impact environnemental de la conception de site web sous php et javascript</h4>
                </div>

                <div class="card-box-main">
                  <div class="card-box-image">
                    <div class="card-img">
                      <img src="images/javascript.jpg" alt="logo javascript" class="card-img">
                    </div>
                    <p class="card-description">Cette formation a pour but de vous faire acquérir des bonnes pratiques dans la réalisation d'un site web afin de réduire son impact environnemental. En passant par les phases d'analyses, de maquettage et enfin de réalisation, vous avancerez pas à pas dans la conception de votre site.</p>
                  </div>
                </div>

                <div class="card-box-footer">
                  <p class="text-center"><span>Formateur :</span> Florian Fleur</p>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </main>

    <?php

    $content = ob_get_clean();

    require "views/common/template.view.php";