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
                    } else if($getPage[1] === "validate"){
                        $controller->validateTeacher($getPage[2]);
                    } else if($getPage[1] === "reject"){
                        $controller->rejectTeacher($getPage[2]);
                    } else if($getPage[1] === 'formation'){
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
                        $getPage3 = intval($getPage[3]);
                    }
                    if(isset($getPage[2])){
                    $formationId = intval($getPage[2]); 
                    }
                    if(isset($getPage[4])){
                        $getPage4 = intval($getPage[4]); 
                        }

                    // améne à l'espace teacher
                    if(!isset($getPage[1])){
                        $controller->setTeacherEspace($_SESSION['id']);

                        
                    // amène à la première leçon d'une page de formation
                    } else if($getPage[1] === 'formation'){
                        if(!isset($getPage3)){
                        $controller->teacherFormationPage($_SESSION['id'], $formationId);
                        // amène à n'importe qu'elle leçon d'une formation
                        } else if(isset($getPage3)){
                        $controller->teacherLessonFormationPage($_SESSION['id'], $formationId, $getPage3);
                        }

                    // met une formation en ligne avec son identifiant
                    } else if($getPage[1] === 'online'){
                        $controller->updateFormationOnline($formationId);

                    // supprime une formation avec son identifiant
                    } else if($getPage[1] === 'delete'){
                        $controller->deleteFormation($formationId);

                    // supprime une section (et ses leçons) avec l'identifiant de la formation et de la section
                    } else if($getPage[1] === 'deleteSection' && isset($getPage[2]) && isset($getPage[3])){
                        $controller->deleteSection($formationId, $getPage3);
                    
                    // Amène au formulaire de création de formation
                    } else if($getPage[1] === 'createFormation'){
                        if(!isset($getPage[2])){
                            $controller->createFormation();
                        // s'il n'y a pas d'étape de section renseigné
                        } else if($getPage[2] === 'step' and !isset($getPage[3])){
                            throw new Exception('Vous ne pouvez pas être sur cette page');
                        // Si le formateur n'est pas passé par la première étape de création du formulaire et a directement modifié l'UR pour passer aux étapes de sections
                        } else if($getPage[2] ==='step' && isset($getPage[3]) && !isset($_SESSION['sections'])){
                            throw new Exception('Vous ne pouvez pas être sur cette page');
                        // si le formateur est passé par la première étape de la formation, il peut renseigner les étapes de sections.
                        } else if($getPage[2] ==='step' && isset($getPage[3])){
                            $controller->createFormationStep($getPage[3]);
                        } else {
                            throw new Exception("Cette page n'existe pas.");
                        }

                    // amène au panneau de modification d'une formation
                    } else if($getPage[1] === 'modify'){
                        // s'il n'y a pas d'identifiant de formation renseigné
                        if(!isset($getPage[2])){
                            throw new Exception('Cette page n\'existe pas');
                        // S'il y a un identifiant de formation renseigné
                        // amène au panneau d'administration - ajout ou suppression de section
                        } else if(isset($getPage[2]) && !isset($getPage[3])){
                            $controller->modifyFormation($formationId);
                        // modification des éléments généraux
                        } else if(isset($getPage[2]) && isset($getPage[3]) && $getPage[3] === 'general'){
                            $controller->modifyFormationGeneral($formationId);
                        } else if(isset($getPage[2]) && isset($getPage[3]) && $getPage[3] === 'step' && isset($getPage[4])){
                            $controller->modifyFormationStep($formationId, $getPage4);
                        }
                    } else {
                        throw new Exception("Vous n'avez pas le droit d'accéder à cette page.");
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
    $errorMsg = $e->getMessage();
    $errorCode = $e->getCode();
    require "views/common/error.view.php";
}