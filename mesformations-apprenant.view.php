<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>EcoIT</title>
    <meta charset="utf-8">
    <meta name="description" content="Corespions est une société privée (totalement fictive) d'espionnage. Nous sommes à votre disposition pour toutes vos idées de sabotage, de vengeance et d'espionnage.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
  </head>
  <body>
  <header >
      <div id="container-pre-header">
      <h1>EcoIT</h1>
      <button type="button" id="connexion-button" class="btn">Connexion</button>
      </div>
      <div id="header-menu" class="d-flex flex-column align-items-center">
          <div id="container-menu">
            <div id="container-item-menu" class="d-flex">
              <a class="menu-item">Accueil</a>
              <a class="menu-item">Apprendre</a>
              <a class="menu-item">Former</a>
            </div>
          </div>
        </div>
    </header>


    <main>

    <div class="container-intro-espace" class="d-flex flex-column align-items-center">
        <p>Bonjour Julie</p>
        <h2>Mes formations</h2>
        
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

                                <a href="Suivre-formation.view.php" class="m-3 btn button-general button-type-2">Accéder</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="en-cours">
                <h3>Mes formations en cours</h3>
                <div class="container-cards" class="d-flex justify-content-center">
                    <div id="container-card">
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
                                    <p class="text-center"><span>Ma progression :</span> 40%</p>
                                </div>
                                <a href="Suivre-formation.view.php" class="m-3 btn button-general button-type-2">Accéder</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="termine">
                <h3>Mes formations terminées</h3>
                <div class="container-cards" class="d-flex justify-content-center">
                    <div id="container-card">
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
                                    <p class="text-center"><span>Ma progression :</span> 100%</p>
                                </div>
                        
                                <a href="Suivre-formation.view.php" class="btn button-general button-type-2 m-3">Accéder</a>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-cards" class="d-flex justify-content-center">
                    <div id="container-card">
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
                                    <p class="text-center"><span>Ma progression :</span> 100%</p>
                                </div>
                        
                                <a href="Suivre-formation.view.php" class="btn button-general button-type-2 m-3">Accéder</a>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>

    </main>
    <footer>

    </footer>
    <script type="text/javascript" src="javascript\jquery-3.6.0.js"></script>
    <script type="text/javascript" src="javascript\bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/script.js"></script>
  </body>
</html>