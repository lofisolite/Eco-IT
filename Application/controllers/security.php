<?php

// constantes
const COOKIE_PROTECT = "timer";

// sécurise chaines de caractères
function secureData($string){
    return htmlspecialchars($string);
}

// Fonctions pour vérifier l'accès aux pages
function genereCookieSession(){
    $timerCookie = session_id().microtime().rand(0,55555);
    $timerCookie = hash("sha256", $timerCookie);
    setCookie(COOKIE_PROTECT, $timerCookie, time() + (360 * 60));
    $_SESSION[COOKIE_PROTECT] = $timerCookie;
}

function verifyCookies(){ 
    if(isset($_SESSION[COOKIE_PROTECT]) && isset($_COOKIE[COOKIE_PROTECT]) && $_SESSION[COOKIE_PROTECT] === $_COOKIE[COOKIE_PROTECT]){
        return true;
    } else {
        session_destroy();
        unset($_SESSION[COOKIE_PROTECT]);
        unset($_SESSION["access"]);
        unset($_SESSION['id']);
        throw new Exception("Vous avez été déconnecté");
    } 
}

function verifyAccessSessionAdmin(){
    return (isset($_SESSION['access']) && !empty($_SESSION['access']) && ($_SESSION['access'] === "admin") && isset($_SESSION['id']) && !empty($_SESSION['id']));
}

function verifyAccessAdmin(){
    return(verifyAccessSessionAdmin() && verifyCookies());
}

function verifyAccessSessionStudent(){
    return (isset($_SESSION['access']) && !empty($_SESSION['access']) && ($_SESSION['access'] === "student") && isset($_SESSION['id']) && !empty($_SESSION['id']));
}

function verifyAccessStudent(){
    return(verifyAccessSessionStudent() && verifyCookies());
}

function verifyAccessSessionTeacher(){
    return (isset($_SESSION['access']) && !empty($_SESSION['access']) && ($_SESSION['access'] === "teacher") && isset($_SESSION['id']) && !empty($_SESSION['id']));
}

function verifyAccessTeacher(){
    return(verifyAccessSessionTeacher() && verifyCookies());
}


//Fonctions pour vérifier les données des formulaires
function verifyPseudo($input, $pseudoList){
    if(!in_array($input, $pseudoList)){
        if(strlen($input) >= 2 && strlen($input) <= 50){
            if(preg_match('/^(?=.+[a-z])[a-zA-Z0-9éèàùâêîôûëçëïüÿ]+$/i', $input)){
                return true;
            } else {
            return "Pseudo : Seulement lettre ou chiffre.";
            }
        } else {
            return "Pseudo : Entre 2 et 50 caractères.";
        }
    } else {
        return "Pseudo : Le pseudo est déjà pris.";
    }
}

function verifyName($input){
    if(strlen($input) >= 2 && strlen($input) <= 50){
        if(preg_match('/^[a-zA-Zéèàùâêîôûëçëïüÿ]{2,}([-\s][a-zéèàùâêîôûëçëïüÿ]+)?$/i', $input)){
            return true;
        } else {
            return "Nom ou prénom : Format non valide, seulement des lettres ou tiret. Ex : Jean-Pierre, jeanne.";
        }
    } else {
        return "Nom ou prénom : Entre 2 et 50 caractères.";
    }
}

function verifyMail($input, $mailList){
    if(!in_array($input, $mailList)){
        if(strlen($input) >= 7 && strlen($input) <= 80){
            if(preg_match('/^([0-9a-zA-Z].*?@([0-9a-zA-Z].*\.\w{2,4}))$/', $input)){
                return true;
            } else {
            return "Mail : Format non valide. Ex : Ex : john.doe@mail.fr.";
            }
        } else {
            return "Mail : Entre 8 et 80 caractères.";
        }
    } else {
        return "Mail : Le mail est déjà enregistré.";
    }
}

function verifyPassword($input){
    if(strlen($input) >= 10 && strlen($input) <= 80){
        if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@%*+\-_!?])[a-zA-Z\d$@%*+\-_!?]{10,}$/', $input)){
            return true;
        } else {
           return "Mot de passe : caractères non autorisés ou caractères manquants, voir les consignes.";
        }
    } else {
        return "Mot de passe : entre 10 et 80 caractères.";
    }
}

function verifyPicture($input){
    $imageTypes = ['jpeg', 'jpg', 'png'];
    $extensionImage = strtolower(pathinfo($input['name'],PATHINFO_EXTENSION));
    if($input['error'] === 0){
        if(is_array(getimagesize($input['tmp_name']))){
            if(in_array($extensionImage, $imageTypes)){
                if($input['size'] < 2000000){
                    return true;
                } else {
                    return 'Photo : l\'image est trop volumineuse';
                }
            } else {
                return 'Photo : Votre fichier n\'est pas une image, voir les consignes.';
            }
        } else{
            return 'Photo : le  fichier n\'est pas une image';
        }  
    } else {
        return 'Photo : Problème avec le téléchargement de l\'image';
    }  
}

// fonction d'ajout d'image
function ajoutImageFile($image, $text, $dir){
    $random = rand(0,9999);
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $imageFile = $dir."_".$random.$text.".".$extension;
    if(!move_uploaded_file($image['tmp_name'], $imageFile)){
        return false;
    } else {
        return $imageFile;
    }
}

function verifyDescription($input){
    if(strlen($input) >= 10 && strlen($input) <= 500){
        if(preg_match('/^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
            return true;
        } else {
            return "Description : Est autorisé : lettre, chiffre ou ('-!?,:.;)..";
        }
    } else {
        return "Description : Entre 10 et 500 caractères.";
    }
}

function verifyFormationTitle($input){
    if(strlen($input) >= 2 && strlen($input) <= 70){
        if(preg_match('/^[a-zéèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
            return true;
        } else {
            return "Titre de la formation : Formation non valide. Est autorisé : lettre ou ('-!?,.:;).";
        }
    } else {
        return "Titre de la formation : Entre 2 et 70 caractères.";
    }
}

function verifyTitleSection($input){
    if(strlen($input) >= 2 && strlen($input) <= 70){
        if(preg_match('/^[a-zéèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function verifyTitleLesson($input){
    if(strlen($input) >= 2 && strlen($input) <= 70){
        if(preg_match('/^[a-zéèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function verifyLessonContent($input){
    if(preg_match('/^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
        return true;
    } else {
        return false;
    }
}

function verifyLessonVideo($input){
    if(preg_match('/^(https?\:\/\/)?(www\.youtube\.com|youtu\.be)\/.+$/', $input)){
        return true;
    } else {
        return false;
    }
}
