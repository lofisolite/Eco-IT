
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>EcoIT</title>
    <meta charset="utf-8">
    <meta name="description" content=".">
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
      <h1><a href="<?=URL ?>accueil">EcoIT</a></h1>
      <?php if(!isset($_SESSION["access"])){ ?>
        <a type="button" id="connexion-button" class="btn" href="<?= URL ?>connexion">Connexion</a>
      <?php } else if(isset($_SESSION["access"])){ ?>
        <form method="POST" action="">
          <input type='hidden' name='deconnexion' value="true"/>
          <button type="submit" id="connexion-button" class="btn" >Déconnexion</button>
        </form>
      <?php } ?>
      </div>
      
      <div id="header-menu" class="d-flex flex-column align-items-center">
          <div id="container-menu">
            <div id="container-item-menu" class="d-flex">
              <a class="menu-item" href="<?=URL ?>accueil">Accueil</a>
              <a class="menu-item" href="<?=URL ?>Sinscription">Apprendre</a>
              <a class="menu-item" href="<?=URL ?>Tinscription">Former</a>
            </div>
          </div>
        </div>
    </header>

        <?= $content ?>


    <footer>

    </footer>
    <script type="text/javascript" src="javascript\general\bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript\general\jquery-3.6.0.js"></script>
    <script type="text/javascript" src="javascript\general\script.js"></script>
    <script type="text/javascript" src="<?= $src ?>"></script>
  </body>
</html>