<?php

require_once "models/Bdd.class.php";
require_once "models/entities/Student.class.php";

class StudentManager extends Bdd
{
    private $students;

    private function addStudent(Student $student){
        $this-> students[] = $student;
    }

    public function getStudents(){
        return $this-> students;
    }

    public function getStudentsMails(){
        foreach($this->students as $student){
            $studentsMails[] = $student->getMail();
        }
        return $studentsMails;
    }

    public function getStudentsPseudos(){
        foreach($this->students as $student){
            $studentsPseudos[] = $student->getPseudo();
        }
        return $studentsPseudos;
    }

    public function loadStudents(){
        $req = "SELECT * FROM student";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $students = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($students as $student){
            $s = new Student($student['id'], $student['pseudo'], $student['mail'], $student['password']);
            $this->addStudent($s);
        }
    }
    
    public function getStudentByMail(string $mail){
        foreach($this->students as $student){
                if($student->getMail() === $mail){
                    return $student;
                }
            }
        throw new Exception("Problème pour récupérer l'étudiant avec son mail.");
    }

    public function isStudentConnexionValid(string $mail, string $password){
        $student= $this->getStudentByMail($mail);
        $bddPassword = $student->getPassword();
        return password_verify($password, $bddPassword);
    }

    // fonctions requêtes Bdd mission
    public function addStudentInBdd(string $pseudo, string $mail, string $password){
        $req ="
        INSERT INTO student(pseudo, mail, password) 
        VALUES(:pseudo, :mail, :password)
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":pseudo", $pseudo, PDO::PARAM_STR);
        $stmt->bindValue(":mail", $mail, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result === true){
            $student = new Student($this->getBdd()->lastInsertId(), $pseudo, $mail, $password);
            $this->addStudent($student);
        } else {
            throw new Exception("Votre inscription n'a pas fonctionné, veuillez réessayer.");
            die();
        }
    }
}