<?php

require_once "models/Bdd.class.php";
require_once "models/entities/FormationByStudent.class.php";

class FormationByStudentManager extends Bdd
{
    private $formationsByStudent;

    private function addFormationByStudent(FormationByStudent $formationByStudent){
        $this-> formationsByStudent[] = $formationByStudent;
    }

    public function getFormationsByStudent(){
        return $this-> formationsByStudent;
    }

    public function loadformationsByStudent(){
        $req = "
        SELECT * FROM student_formation
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $formationsByStudent = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($formationsByStudent as $formationByStudent){
            $f = new FormationByStudent($formationByStudent['id_student'], $formationByStudent['id_formation'], $formationByStudent['status'], $formationByStudent['progression']);
            $this->addFormationByStudent($f);
        }
    }
}