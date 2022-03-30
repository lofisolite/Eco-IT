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
    
        <h2>Inscription formateur</h2>

        <div class="text-explication">
          <p class="text-align">Une fois inscrit, nous vous contacterons pour un entretien.</p>
          
        </div>
        <div class="d-flex justify-content-center" >
            <form action="" enctype="multipart/form-data" method="POST" class="form d-flex flex-column" id="formInscription">
                <p id="errorMsg" class="mb-3 error-msg"></p>
                <div class="mb-3">
                    <p id="errorFirstname" class="mb-3 error-msg"></p>
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="" minlength="2" maxlength="50" required>
                </div>
                <div class="mb-3">
                    <p id="errorLastname" class="mb-3 error-msg"></p>
                    <label for="lastname" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="" minlength="2" maxlength="50" required>
                </div>
                <div class="mb-3">
                    <p id="errorPictureProfil" class="mb-3 error-msg"></p>
                    <label for="pictureProfil" class="form-label">Photo de profil</label>
                    <input type="file" class="form-control" id="pictureProfil" name="pictureProfil" accept="image/png, image/jpeg" required>
                </div>
                <div class="mb-3">
                    <p id="errorDescription" class="mb-3 error-msg"></p>
                    <label for="description" class="form-label">Décrivez vous</label>
                    <p class="explication-msg mb-3">Maximum 500 caractères sur votre parcours et vos spécialités.</p>
                    <textarea class="form-control" id="ZoneTexte" name="description" value="" cols="30" rows="6" min="2" max="500" required></textarea>
                    <div id="compteur" style="text-align:right">0</div>
                </div>
                <script>
                    document.getElementById('ZoneTexte').addEventListener('keyup', function() {
                        document.getElementById('compteur').innerHTML = document.getElementById('ZoneTexte').value.length;
                     });
                </script>
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
    <script type="text/javascript" src="javascript/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="javascript/script.js"></script>
  </body>
</html>