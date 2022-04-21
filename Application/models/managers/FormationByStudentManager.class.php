<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/FormationByStudent.class.php');

class FormationByStudentManager extends Bdd
{
    private $formationsByStudentNotstarted;
    private $formationsByStudentStarted;
    private $formationsByStudentFinished;

    private function addFormationByStudentNotStarted(FormationByStudent $formationByStudent){
        $this-> formationsByStudentNotstarted[] = $formationByStudent;
    }

    public function getFormationsByStudentNotStarted(){
        return $this-> formationsByStudentNotstarted;
    }

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

            if($f->getStatus() === 'non suivi' && $f->getProgression() !== 100){
                $this->addFormationByStudentNotStarted($f);
            } else if($f->getStatus() === 'suivi' && $f->getProgression() !== 100){
                $this->addFormationByStudentStarted($f);
            } else if($f->getStatus() === 'suivi' && $f->getProgression() === 100){
                $this-> addFormationByStudentFinished($f);
            }
        }
    }

    // passe la formation non suivi en suivi
    public function updateFormationByStudentStatus($studentId, $formationId){
        $req ="
        UPDATE student_formation
        SET status = 'suivi'
        WHERE id_student = :id_student
        AND id_formation = :id_formation
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
        $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
        
        if($result === false){
            throw new Exception('La formation ne peux pas être ajoutée à vos formations en cours.');
        }
    }

    // modifie la progression d'une formation
    public function updateFormationByStudentProgression($studentId, $formationId, $progression){
        $req ="
        UPDATE student_formation
        SET progression = :progression
        WHERE id_student = :id_student
        AND id_formation = :id_formation
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
        $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
        $stmt->bindValue(":progression", $progression, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();
            
        if($result === false){
                
            //throw new Exception('La formation ne peux pas être ajoutée à vos formations en cours.');
        }
    }

    // à l'inscription d'un étudiant, ajout à son compte des formations en ligne
    public function addStudentByFormationOnline($formationsId, $studentId){
        foreach($formationsId as $formationId){
            $req ="
            INSERT INTO student_formation(id_student, id_formation, status, progression) 
            VALUES(:id_student, :id_formation, :status, :progression)
            ";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
            $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
            $stmt->bindValue(":status", 'non suivi', PDO::PARAM_STR);
            $stmt->bindValue(":progression", '0', PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
        }

        if($result === false){
            die();
        }
    }


    // lorsqu'un formateur passe une formation en ligne, ajouter la formation à tous les élève
    public function addFormationToStudent($formationId, $studentsId){
        foreach($studentsId as $studentId){
            $req ="
            INSERT INTO student_formation(id_student, id_formation, status, progression) 
            VALUES(:id_student, :id_formation, :status, :progression)
            ";
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
            $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
            $stmt->bindValue(":status", 'non suivi', PDO::PARAM_STR);
            $stmt->bindValue(":progression", '0', PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
        }

        if($result === false){
            die();
        }
    }

}