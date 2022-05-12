
# Formation EcoIt

Ce projet a été réalisé lors d'une évaluation dans le cadre de ma formation de développeur web full stack à Studi.

Formation-EcoIt est l'application web de l'entreprise fictive EcoIt qui  propose des formations basées sur l'eco conception web. 




## Auteur

- [@helene lacaze](https://github.com/lofisolite)



## Lien du site

https://www.formation-ecoit.fr


## Deploiement en local


Exemple avec le terminal de commande en ligne windows Powershell


Etape 1 : Créer un dossier
```bash
  mkdir local-test
```

Etape 2 : Se rendre dans le répertoire

```bash
  cd 'chemin de mon dossier'
```

Etape 3 : cloner le projet
```bash
  git clone https://github.com/lofisolite/Eco-IT.git
```

*Note :* les librairies sont déjà incluses dans le dossier.

L'application se trouve dans le dossier application. Tous les documents (conception, maquettage, documentation technique, commande sql...) se trouvent dans le dossier documents.


Etape 4 : Copier le dossier "Application" (le renommer si vous voulez) et le coller dans le dossier de votre serveur local

Pour MAMP
C:\MAMP\htdocs

pour WAMP
c:\wamp\www


Etape 5 : Ouvrir le dossier application avec votre éditeur de code


Etape 6 : Modifier le fichier config.php se situant à la racine du dossier Application.

Cela permet à l'application d'accéder à tous les fichiers en utilisant la fonction require à partir de n'importe quel fichier avec le chemin absolu de votre dossier.

A la ligne 7, modifier le contenu de la constante ROOT avec le chemin absolu de votre dossier.

Ex : define("ROOT", "C:\MAMP\htdocs\Application");


Etape 7 : Modifier le fichier ajax.js - application/script/ajax/ajax.js 
Cela permet au fichier javascript responsable des appels au serveur en méthode Ajax de fournir l'url du fichier php controllerAjax.php en partant de son chemin absolu.

A la ligne 1, donner le nom du dossier utilisé.

Ex : let url = document.location.origin + '/Application/';


Etape 8 : Créer une base de donnée mysql du nom de sp_eco

Etape 9 : Importer via phpmyadmin le fichier sql sp_eco.sql situé à la racine du dossier "document" - local-test/Eco-It/documents/sp_eco.sql

Par mesure de sécurité, je ne fournis que la structure des tables de la base de donnée, pas les données.