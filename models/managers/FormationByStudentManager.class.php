<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/FormationByStudent.class.php');

class FormationByStudentManager extends Bdd
{
    private $formationsByStudentStarted;
    private $formationsByStudentFinished;

    private function addFormationByStudentStarted(FormationByStudent $formationByStudent){
        $this-> formationsByStudentStarted[] = $formationByStudent;
    }

    public function getFormationsByStudentStarted(){
        return $this-> formationsByStudentStarted;
    }

    private function addFormationByStudentFinished(FormationByStudent $formationByStudent){
        $this-> formationsByStudentFinished[] = $formationByStudent;
    }

    public function getFormationsByStudentFinished(){
        return $this-> formationsByStudentFinished;
    }

   // charge toutes les formations suivis par un étudiant avec son id
    public function loadformationsByStudent($studentId){
        $req = "
        SELECT * FROM student_formation
        WHERE id_student = :id_student
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt->bindValue(':id_student', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        $formationsByStudent = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($formationsByStudent as $formation){
            $f = new FormationByStudent($formation['id_student'], $formation['id_formation'], $formation['status'], $formation['progression']);

            if($f->getStatus() === 'suivi' && $f->getProgression() !== 100){
                $this->addFormationByStudentStarted($f);
            } else if($f->getProgression() === 100){
                $this-> addFormationByStudentFinished($f);
            }
        }
    }
}