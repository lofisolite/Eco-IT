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
    setCookie(COOKIE_PROTECT, $timerCookie, time() + (120 * 60));
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
            return "Pseudo : Caractères non autorisés.";
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
            return "Nom ou prénom : Caractères non autorisés.";
        }
    } else {
        return "Nom ou prénom : Entre 2 et 50 caractères.";
    }
}

function verifyMail($input){
    if(strlen($input) >= 7 && strlen($input) <= 80){
        if(preg_match('/^([0-9a-zA-Z].*?@([0-9a-zA-Z].*\.\w{2,4}))$/', $input)){
            return true;
        } else {
           return "Mail : Caractères non autorisés.";
        }
    } else {
        return "Mail : Entre 8 et 80 caractères.";
    }
}

function verifyPassword($input){
    if(strlen($input) >= 10 && strlen($input) <= 80){
        if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@%*+\-_!?])[a-zA-Z\d$@%*+\-_!?]{10,}$/', $input)){
            return true;
        } else {
           return "Mot de passe : caractères non autorisés ou caractères manquants.";
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
                if($input['size'] < 1000000){
                    return true;
                } else {
                    return 'Photo : l\'image est trop volumineuse';
                }
            } else {
                return 'Photo : l\'image n\'est pas au bon format.';
            }
        } else{
            return 'Photo : le  fichier n\'est pas une image';
        }  
    } else {
        return 'Photo : Problème avec le téléchargement de l\'image';
    }  
}

function verifyDescription($input){
    if(strlen($input) >= 2 && strlen($input) <= 500){
        if(preg_match('/^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
            return true;
        } else {
            return "Description : Caractères non autorisés.";
        }
    } else {
        return "Description : Entre 2 et 500 caractères.";
    }
}

function verifyFormationTitle($input){
    if(strlen($input) >= 2 && strlen($input) <= 80){
        if(preg_match('/^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
            return true;
        } else {
            return "Titre : Caractères non autorisés.";
        }
    } else {
        return "Titre : Entre 2 et 80 caractères.";
    }
}

function verifyTitle($input){
    if(strlen($input) >= 2 && strlen($input) <= 60){
        if(preg_match('/^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
            return true;
        } else {
            return "Titre : Caractères non autorisés.";
        }
    } else {
        return "Titre : Entre 2 et 60 caractères.";
    }
}

function verifyContent($input){
    if(preg_match('/^[a-z0-9éèàùâêîôûëçëïüÿ\s\'\-\.\!\?\,\:\;]+$/i', $input)){
        return true;
    } else {
        return "contenu lesson : Caractères non autorisés.";
    }
}

function verifyVideo($input){
    if(preg_match('/(https\:\/\/){0,}(www\.){0,}(youtube\.com){1}(\/watch\?v\=[^\s]){1})/', $input)){
        return true;
    } else {
        return "video : la vidéo n'est pas une vidéo youtube";
    }
}


