<?php
session_start();

if(isset($_POST['deconnexion']) && !empty($_POST['deconnexion']) && $_POST['deconnexion'] === 'true'){
  session_destroy();
  header("location: accueil");
}

require_once "controllers/config.php";
require_once "controllers/security.php";
require_once "controllers/Controleur.php";

$controller = new Controleur;


try{
    if(empty($_GET['page'])){
      require_once 'views/common/accueil.view.php';
    } else {
      $getPage = explode("/", secureData($_GET['page']));

      switch($getPage[0]){
          case "accueil" :
            require_once 'views/common/accueil.view.php';
          break;

          case "connexion" :
              $controller->toLogin();
          break;
        
          case "Sinscription" :
            $controller->signUpStudent();
          break;

          case "Tinscription" :
            $controller->signUpTeacher();
          break;

          case "adminEspace" :
              if(verifyAccessAdmin()){
                require_once 'views/admin/admin-espace.view.php';
              } else {
                throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
              }
          break;

          case "studentEspace" :
            if(verifyAccessStudent()){
              $controller->setStudentEspace();
            } else {
              throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
            }
          break;

          case "teacherEspace" :
            if(verifyAccessTeacher()){
              require_once 'views/teacher/teacher-espace.view.php';
            } else {
              throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
            }
          break;
      default : throw new Exception("la page n'existe pas");
      }
    }

}

catch(Exception $e){
    $ErrorMsg = $e->getMessage();
    require "views/common/error.view.php";
}