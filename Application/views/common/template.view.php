
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title><?= $titleHead ?></title>
    <meta name="description" content="EcoIT vous propose des formations gratuite de développement web basé sur l'éco-conception">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= URL ?>style/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= URL ?>style/style.css" >
  </head>
  <body>
  <header >
      <div id="container-pre-header">
      <h1><a href="<?=URL ?>accueil">EcoIT</a></h1>

      <?php if(!isset($_SESSION["access"])){ ?>
        <a type="button" class="btn connexion-button" href="<?= URL ?>connexion">Connexion</a>

      <?php } else if(isset($_SESSION["access"])){ ?>

          <form method="POST" action="">
            <input type='hidden' name='deconnexion' value="true"/>
            <button type="submit" class="connexion-button btn" >Déconnexion</button>
          </form>

          <?php if($_SESSION["access"] === 'admin'){ ?>
              <a type="button" class="btn-espace btn button-type-1" href="<?= URL ?>adminEspace">Mon espace</a>
          <?php } else if($_SESSION["access"] === 'student'){ ?>
              <a type="button" class="btn-espace btn button-type-1" href="<?= URL ?>studentEspace">Mon espace</a>
          <?php } else if($_SESSION["access"] === 'teacher'){ ?>
              <a type="button" class="btn-espace btn button-type-1" href="<?= URL ?>teacherEspace">Mon espace</a>
          <?php } 
      } ?>

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
      <div class="footer-left">
          <p class="footer-links">
            <a href="#" class="link-1">Accueil</a>
            <a href="<?=URL ?>Sinscription"">Apprendre</a>
            <a href="<?=URL ?>Tinscription"">Former</a>
            <a href="<?=URL ?>credits"">Crédits</a>
          </p>

        <p class="footer-company-name">EcoIt © <?= date('Y', time()); ?></p>
      </div>

      <div class="footer-center">
        <div class="container-footer-center">
          <div class="box-footer-center">
              <div>
                <img src="<?= URL ?>public/images/general/gps.png" alt="">
                <p>18 rue de l'écologie <br> Paris</p>
              </div>
              <div>
                <img src="<?= URL ?>public/images/general/phone.png" alt="">
                <p>00.55.55.55</p>
              </div>
              <div>
                <img src="<?= URL ?>public/images/general/arobas.png">
                <p><a href="mailto:formation-EcoIt@company.com">formation-EcoIt@company.com</a></p>
              </div>
          </div>
        </div>
      </div>

      <div class="footer-right">
          <div class="box-footer-right">
            <p class="footer-social">Nos Réseaux</p>

            <div class="footer-icons">
              <a href="#"><img src="<?= URL ?>public/images/general/facebook.png" alt=""></a>
              <a href="#"><img src="<?= URL ?>public/images/general/instagram.png" alt=""></a>
              <a href="#"><img src="<?= URL ?>public/images/general/twitter.png" alt=""></a>
            </div>
          </div>
      </div>
    </footer>
    <script type="text/javascript" src="<?= URL ?>script\general\bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= URL ?>script\general\jquery-3.6.0.js"></script>
    <?php if(isset($src)){ ?>
    <script type="text/javascript" src="<?= URL.$src ?>"></script>
    <?php } ?>
    <?php if(isset($src2)){ ?>
    <script type="text/javascript" src="<?= URL.$src2 ?>"></script>
    <?php } ?>
    <?php if(isset($src3)){ ?>
    <script type="text/javascript" src="<?= URL.$src3 ?>"></script>
    <?php } ?>
  </body>
</html>