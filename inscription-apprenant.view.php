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

    <main id="main-inscription">
    
        <h2>Inscription apprenant</h2>

        <div class="d-flex justify-content-center" >
            <form action="" method="POST" class="form d-flex flex-column" id="formInscription">
                <p id="errorMsg" class="mb-3 error-msg"></p>
                <div class="mb-3">
                    <p id="errorPseudo" class="mb-3 error-msg"></p>
                    <label for="pseudo" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="pseudo" value="" minlength="2" maxlength="50" required>
                </div>
                <div class="mb-3">
                    <p id="errorMail" class="mb-3 error-msg"></p>
                    <label for="mail" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" id="mail" name="mail" value="" minlength="2" maxlength="80" required>
                </div>
                <div class="mb-3">
                    <p id="errorPassword" class="mb-3 error-msg"></p>
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="container-password">
                        <input type="password" class="form-control" id="password" name="password" value="" min="2" max="80" required>
                        <img id="eye" src="images/notvisible.png" alt="">
                    </div>
                </div>
                <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
            </form>
        </div>

    </main>
    <footer>

    </footer>
    <script type="text/javascript" src="javascript\jquery-3.6.0.js"></script>
    <script type="text/javascript" src="javascript\bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/script.js"></script>
  </body>
</html>