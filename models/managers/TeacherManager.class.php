<?php

require_once "models/Bdd.class.php";
require_once "models/entities/Teacher.class.php";

class TeacherManager extends Bdd
{
    private $teachersValidate;
    private $teachersNotValidate;

    private function addTeacherValidate(Teacher $teacherValidate){
        $this-> teachersValidate[] = $teacherValidate;
    }

    public function getTeachersValidate(){
        return $this-> teachersValidate;
    }

    public function getTeachersValidateMails(){
        foreach($this->teachersValidate as $teacher){
            $teachersValidateMails[] = $teacher->getMail();
        }
        return $teachersValidateMails;
    }

    private function addTeacherNotValidate(Teacher $teacherNotValidate){
        $this-> teachersNotValidate[] = $teacherNotValidate;
    }

    public function getTeachersNotValidate(){
        return $this-> teachersNotValidate;
    }

    public function loadTeachers(){
        $req = "
        SELECT * FROM teacher
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $teachers = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($teachers as $teacher){
            $t = new Teacher($teacher['id'], $teacher['firstname'], $teacher['lastname'], $teacher['mail'], $teacher['password'], $teacher['url_picture_profile'], $teacher['description'], $teacher['validation']);
                
            if($t->getValidation() === 'oui'){
                $this->addTeacherValidate($t);
            } else if($t->getValidation() === 'non'){
                $this->addTeacherNotValidate($t);
            }
        }
    }

    public function getTeacherValidateByMail(string $mail){
        foreach($this->teachersValidate as $teacher){
                if($teacher->getMail() === $mail){
                    return $teacher;
                }
            }
        throw new Exception("Problème pour récupérer le formateur avec son mail.");
    }

    public function getTeacherNotValidateByMail(string $mail){
        foreach($this->teachersNotValidate as $teacher){
                if($teacher->getMail() === $mail){
                    return $teacher;
                }
            }
        throw new Exception("Problème pour récupérer le formateur avec son mail.");
    }

    public function isTeacherValidateConnexionValid(string $mail, $password){
        $teacherValidate = $this->getTeacherValidateByMail($mail);
        $bddPassword = $teacherValidate->getPassword();
        return password_verify($password, $bddPassword);
    }

    // fonctions requêtes Bdd mission
    public function addTeacherInBdd(string $firstname, string $lastname, string $mail, string $password, string $pictureProfile, string $description){
        $req ="
        INSERT INTO teacher(firstname, lastname, mail, password, url_picture_profile, description, validation) 
        VALUES(:firstname, :lastname, :mail, :password, :url_picture_profile, :description, :validation)
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":firstname", $firstname, PDO::PARAM_STR);
        $stmt->bindValue(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":url_picture_profile", $pictureProfile, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":validation", "non", PDO::PARAM_STR);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result === true){
            $teacher = new Teacher($this->getBdd()->lastInsertId(), $firstname, $lastname, $pictureProfile, $description, $mail, $password, 'non');
            $this->addTeacherNotValidate($teacher);
        } else {
            throw new Exception("Votre inscription n'a pas fonctionné, veuillez réessayer.");
            die();
        }
    }
}