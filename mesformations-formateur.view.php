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

    <div class="container-intro-espace">
        <p>Bonjour Jean-Louis</p>
        <h2>Mes formations</h2>
        <div class="text-explication">
          <p class="text-align">Lorsque vous créez une formation, elle est hors ligne.</p>
          <p class="text-align"> Avant de la mettre en ligne, vous pouvez voir votre formation comme elle sera présentée pour les apprenants et la modifier si besoin puis la mettre en ligne. Elle apparaîtra alors dans le repertoire des formations.</p>
          <p class="text-align">Une fois en ligne, vous pouvez toujours modifier votre formation.</p>
          <div class="d-flex justify-content-center m-3">
            <a class="btn button-general button-type-2">Créer une formation</a>
          </div>
        </div>

        <div class="container-main">
          <h3>Formations hors ligne</h3>

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

                <div class="card-box-footer formation-buttons-teacher">
                        <div id="box-buttons-teacher">
                            <a href="formateur-detailFormation.view.php" class="btn button-general button-type-2 little-button">Voir le détail</a>
                            <a class="btn button-general button-type-2">Modifier</a>
                            <a class="btn button-general button-type-2">Mettre en ligne</a>
                        </div>
                </div>
           
              </div>
            </div>


          </div>
        </div>

        <h3>Formations en ligne</h3>
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

                <div class="card-box-footer formation-buttons-teacher ">
                        <div class="d-flex justify-content-center">
                            <a class="btn button-general button-type-2 align-self-center">Voir le détail</a>
                            <a class="btn button-general button-type-2">Modifier</a>
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