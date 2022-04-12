<?php
session_start();

// appel fichiers constantes URL et ROOT
require 'config.php';


if(isset($_POST['deconnexion']) && $_POST['deconnexion'] === 'true'){
  session_destroy();
  header("Location: ". URL . "accueil");
}

require_once(ROOT.'/controllers/security.php');
require_once(ROOT.'/controllers/Controller.php');

$controller = new Controller;

try{
    if(empty($_GET['page'])){
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
                $controller->test();
            break;

            case "Tinscription" :
                $controller->signUpTeacher();
            break;

            case "credits" :
                require_once "views/common/credits.view.php";
            break;

            case "adminEspace" :
                if(verifyAccessAdmin()){
                    if(isset($getPage[3])){
                        $lessonId = intval($getPage[3]);
                    }
                    if(isset($getPage[2])){
                    $formationId = intval($getPage[2]); 
                    }

                    if(empty($getPage[1])){
                        $controller-> setAdminEspace(); 
                    }
                    
                    if($getPage[1] === "validate"){
                        $controller->validateTeacher($getPage[2]);
                    } else if($getPage[1] === "reject"){
                        $controller->rejectTeacher($getPage[2]);

                    }
                    
                    if($getPage[1] === 'formation'){
                        if(!isset($lessonId)){
                            $controller->adminFormationPage($formationId);
                        } else if(isset($lessonId)){
                            $controller->adminLessonFormationPage($formationId, $lessonId);
                        }
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accéder à cette page d'administration.");
                }
            break;

            case "studentEspace" :
                if(verifyAccessStudent()){
                    if(isset($getPage[3])){
                        $lessonId = intval($getPage[3]);
                    }
                    if(isset($getPage[2])){
                    $formationId = intval($getPage[2]); 
                    }
                    
                    if(!isset($getPage[1])){
                        $controller->setStudentEspace($_SESSION['id']);
                    } else if($getPage[1] === "formation" && !isset($lessonId)){
                        $controller->studentFormationPage($_SESSION['id'], $formationId);
                    } else if($getPage[1] === "formation" && isset($lessonId)){
                        $controller->studentLessonFormationPage($_SESSION['id'], $formationId, $lessonId);
                    }
                } else {
                    throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
                }
                
            break;


            case "teacherEspace" :
                if(verifyAccessTeacher()){
                    if(isset($getPage[3])){
                        $lessonId = intval($getPage[3]);
                    }
                    if(isset($getPage[2])){
                    $formationId = intval($getPage[2]); 
                    }

                    if(!isset($getPage[1])){
                        $controller->setTeacherEspace($_SESSION['id']);

                    } else if($getPage[1] === 'formation'){
                           
                        if(!isset($lessonId)){
                        $controller->teacherFormationPage($_SESSION['id'], $formationId);
                        } else if(isset($lessonId)){
                        $controller->teacherLessonFormationPage($_SESSION['id'], $formationId, $lessonId);
                        }

                    } else if($getPage[1] === 'online'){
                        $controller->updateFormationOnline($formationId);

                    } else if($getPage[1] === 'create'){
                        if(!isset($getPage[2])){
                            $controller->createFormation();
                        } else if($getPage[2] ==='step'){
                            $controller->createFormationStep($getPage[3]);
                        }
                    }/* else if($getPage[1] === 'modify'){
                        $controller->modifyFormation($formationId);
                    }
                    */
                } else {
                  throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
                }
            break;
            default : throw new Exception("La page n'existe pas");
        }
    }
}

catch(Exception $e){
    $errorMsg = $e->getMessage();
    $errorCode = $e->getCode();
    require "views/common/error.view.php";
}