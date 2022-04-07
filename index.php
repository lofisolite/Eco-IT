<?php
session_start();

if(isset($_POST['deconnexion']) && !empty($_POST['deconnexion']) && $_POST['deconnexion'] === 'true'){
  session_destroy();
  header("location: accueil");
}

// appel fichiers constantes URL et ROOT
require 'config.php';

require_once(ROOT.'/controllers/security.php');
require_once(ROOT.'/controllers/Controller.php');

$controller = new Controller;

try{
    if(empty($_GET['page'])){
        //require_once(ROOT.'/views/common/accueil.view.php');
        $controller->setHomePage();
    } else {
        $getPage = explode("/", secureData($_GET['page']));

        switch($getPage[0]){
            case "accueil" :
                $controller->setHomePage();
            break;

            case "connexion" :
                $controller->toLogin();
            break;
        
            case "Sinscription" :
                $controller->signUpStudent();
            break;

            case "test" :
                $controllerAjax->displayFormations();
            break;

            case "Tinscription" :
                $controller->signUpTeacher();
            break;

            case "credits" :
                require_once "views/common/credits.view.php";
            break;

            case "adminEspace" :
                if(verifyAccessAdmin()){
                    if(empty($getPage[1])){
                        $controller-> setAdminEspace(); 
                    } else if($getPage[1] === "validate"){
                        $controller->validateTeacher($getPage[2]);
                    } else if($getPage[1] === "reject"){
                        $controller->rejectTeacher($getPage[2]);
                    } 
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accéder à cette page d'administration.");
                }
            break;

            case "studentEspace" :
                if(verifyAccessStudent()){
                    if(empty($getPage[1])){
                        $controller->setStudentEspace($_SESSION['id']);
                    } else if($getPage[1] === 'formation'){
                        //$controller->studentFormationPage();
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
                }
                
            break;

            case "teacherEspace" :
                if(verifyAccessTeacher()){
                    if(empty($getPage[1])){
                        $controller->setTeacherEspace($_SESSION['id']);
                    } else if($getPage[1] === 'formation'){
                        //$controller->teacherFormationPage();
                    }
                } else {
                  throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
                }
            break;
            default : throw new Exception("La page n'existe pas");
        }
    }
}

catch(Exception $e){
    $ErrorMsg = $e->getMessage();
    require "views/common/error.view.php";
}