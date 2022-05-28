
# Formation EcoIt
## Description
Réalisation de l'application Formation-EcoIt pour l'entreprise fictive EcoIt qui propose des formations basées sur l'eco conception web.

Projet réalisé en modèle MVC.


### Fonctionnalités : 
- **Visiteur** : Accès aux cartes des trois dernières formations, recherche par mot clef de formation.
- **Apprenant** : Accès aux formations, possibilité de valider les leçons d'une formation et de passer des leçons dans un onglet "formation en cours" et un onglet "formation terminées".
- **Formateur** : Création, modification, suppression et mise en ligne de formations.
- **Administeur** : Valide ou rejette les candidatures des formateurs

## Lien du site
https://www.formation-ecoit.fr

## Technologies utilisés
- HTML
- CSS & BootStrap
- JavaScript & Jquery
- PHP

**Logiciels :**
- Adobe XD pour les maquettes
- GitMind pour les diagrammes
- Tableau Kanban pour l'organisation : https://trello.com/b/bjbxE9oX/projet-ecf

## Contenu du dépot
### Dossier Application
Fichiers du projet en local

### Dossier Documents
#### Conception
- Modèle de conception
- Persona 
- User Stories

#### Diagrammes
- Diagrammes de séquence
- Diagramme de cas d'utilisation
- Diagramme de classe

#### Maquettage :
Wireframes version mobile et desktop page d'accueil, page pour suivre une formation et page administrateur.

#### PDF :
- Charte graphique
- Commandes SQL BDD
- Documentation technique
- Manuel d'utilisation


## Deploiement en local
Exemple avec le terminal de commande en ligne windows Powershell


**Etape 1** : Créer un dossier
```bash
  mkdir local-test
```

**Etape 2** : Se rendre dans le répertoire

```bash
  cd chemin de mon dossier/local-test
```

**Etape 3** : cloner le projet
```bash
  git clone https://github.com/lofisolite/Eco-IT.git
```
<br />
<br />

**Note :** les librairies sont déjà incluses dans le dossier.

L'application se trouve dans le dossier application. Tous les documents (conception, maquettage, documentation technique, commande sql...) se trouvent dans le dossier documents.
<br />
<br />

**Etape 4** : Copier le dossier "Application" et le coller dans le dossier de votre serveur local

Pour MAMP
C:\MAMP\htdocs

pour WAMP
c:\wamp\www

<br />
<br />

**Etape 5** : Ouvrir le dossier Application avec votre éditeur de code

<br />
<br />

**Etape 6** : Modifier le fichier **config.php** se situant à la racine du dossier Application.


Cela permet à l'application d'accéder à tous les fichiers en utilisant la fonction require à partir de n'importe quel fichier avec le chemin absolu de votre dossier.


A la ligne 7, modifier le contenu de la constante ROOT avec le chemin absolu de votre dossier.


Ex : define("ROOT", "C:\MAMP\htdocs\Application");

<br />
<br />

**Etape 7** : Modifier le fichier **ajax.js** - Application/script/ajax/ajax.js 


Cela permet au fichier javascript responsable des appels au serveur en méthode Ajax de fournir l'url du fichier php controllerAjax.php en partant de son chemin absolu.


A la ligne 1, donner le nom du dossier utilisé.


Ex : let url = document.location.origin + '/Application/';

<br />
<br />

**Etape 8** : Créer une base de donnée mysql du nom de sp_eco

<br />
<br />

**Etape 9** : Importer via phpmyadmin le fichier sql sp_eco.sql situé à la racine du dossier "document" - local-test/Eco-It/documents/sp_eco.sql


Par mesure de sécurité, je ne fournis que la structure des tables de la base de donnée, pas les données.
