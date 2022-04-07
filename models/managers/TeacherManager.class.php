<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/Teacher.class.php');

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

    // récupère tous les mails des formateurs validés
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

    // récupère un formateur validé - lors de la connexion, permet de récupérer son mot de passe et autoriser ou non sa connexion.
    public function getTeacherValidateByMail(string $mail){
        foreach($this->teachersValidate as $teacher){
            if($teacher->getMail() === $mail){
                return $teacher;
            }
        }
        throw new Exception("Problème pour récupérer le formateur avec son mail.");
    }
    
    // récupére un formateur non validés - permet de récupérer la photo d'un formateur rejeté par l'admin pour la supprimer.
    public function getTeacherNotValidateById(int $teacherId){
        foreach($this->teachersNotValidate as $teacher){
            if($teacher->getId() === $teacherId){  
                return $teacher;
            }
        }
    }
    
    // récupére un formateur validé - permet d'afficher les informations des formateurs en fournissant leur identifiants
    public function getTeacherValidateById(int $teacherId){
        foreach($this->teachersValidate as $teacher){
            if($teacher->getId() === $teacherId){
                return $teacher;
            }
        }
    }
    
    // Lors de la connexion, verifie qu'un formateur validé donne ses bons identifiants.
    public function isTeacherValidateConnexionValid(string $mail, string $password){
        $teacher = $this->getTeacherValidateByMail($mail);
        $bddPassword = $teacher->getPassword();
        return password_verify($password, $bddPassword);
    }

    // Fonctions requêtes
    // récupère tous les formateurs.
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

    // ajoute un formateur (non validé) en Bdd
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
        } else {
            throw new Exception("Votre inscription n'a pas fonctionné, veuillez réessayer.");
            die();
        }
    }

    // passe la propriété "validation" de non à oui par l'action de l'admin.
    public function validateTeacherInBdd(int $id){
        $req ="
        UPDATE teacher
        SET validation = :validation
        Where id = :id
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->bindValue(":validation", "oui", PDO::PARAM_STR);
        $result = $stmt->execute();
        $stmt->closeCursor();

        return $result;
    }

    // supprime un formateur de la base de donnée par action de l'admin
    public function deleteTeacherInBdd(int $teacherId){
        $req ="
        DELETE FROM teacher WHERE id = :id
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id", $teacherId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        return $result;
    }
}