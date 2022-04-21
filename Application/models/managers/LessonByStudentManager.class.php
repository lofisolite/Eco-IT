<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/LessonByStudent.class.php');

class LessonByStudentManager extends Bdd
{
    private $lessonsByStudent;

    // nécessaire?
    private function addLessonByStudent(LessonByStudent $lessonByStudent){
        $this-> lessonsByStudent[] = $lessonByStudent;
    }

    // nécessaire?
    public function getLessonsByStudent(){
        return $this-> lessonsByStudent;
    }

    public function getNbrStatusLessonByStudent($studentId, $formationId){
        $req = "
        SELECT status FROM student_lesson
        WHERE id_student = :id_student
        AND id_formation = :id_formation 
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
        $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
        $result = $stmt -> execute();
        $lessonsByStudent = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if($result === true){
            $totalLesson = 0;
            $finishedLesson = 0;

            foreach($lessonsByStudent as $lessonByStudent){
            $totalLesson++;
            if($lessonByStudent['status'] === 'terminé'){
                $finishedLesson++;
            }
        }
        $lessonByStudentStatustable['totalLessonNbr'] = $totalLesson;
        $lessonByStudentStatustable['finishedLessonNbr'] = $finishedLesson;

        return $lessonByStudentStatustable;
        } else {
            return false;
        }
        
    }

    // fonctions requêtes bdd
    // charge toutes les lignes des lessons par étudiant
    // nécessaire?
    public function loadlessonsByStudent(){
        $req = "
        SELECT * FROM student_lesson
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $lessonsByStudent = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($lessonsByStudent as $lessonByStudent){
            $l = new LessonByStudent($lessonByStudent['id_student'], $lessonByStudent['id_lesson'], $lessonByStudent['id_formation'], $lessonByStudent['status']);
            $this->addLessonByStudent($l);
        }
    }

    public function getLessonByStudentStatus($studentId, $lessonId){
        $req = "
        SELECT status FROM student_lesson
        WHERE id_student = :id_student
        AND id_lesson = :id_lesson 
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
        $stmt->bindValue(":id_lesson", $lessonId, PDO::PARAM_INT);
        $stmt -> execute();
        $lessonByStudent = $stmt-> fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        if($lessonByStudent){
            return $lessonByStudent;
        }
    }

     // passe la lesson non suivi en suivi
    public function updateLessonByStudentStatus($studentId, $lessonId, $status){
        if($status === 'en cours'){
            $req ="
            UPDATE student_lesson
            SET status = 'en cours'
            WHERE id_student = :id_student
            AND id_lesson = :id_lesson
            ";
        } else if($status === 'terminé'){
            $req ="
            UPDATE student_lesson
            SET status = 'terminé'
            WHERE id_student = :id_student
            AND id_lesson = :id_lesson
            ";
        }

        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
        $stmt->bindValue(":id_lesson", $lessonId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $count = $stmt->rowCount();
        $stmt->closeCursor();   
    }

    // a l'inscription d'un étudiant, lui ajoute toutes les lessons de toutes les formations
    public function addStudentToLessons($tableFormationLesson, $studentId){
        foreach($tableFormationLesson as $table){
            $formationId = $table['formationId'];
            foreach($table['lessonId'] as $lessonId){
                $req ="
                INSERT INTO student_lesson(id_student, id_lesson, id_formation, status) 
                VALUES(:id_student, :id_lesson, :id_formation, :status)
                ";
                $stmt = $this->getBdd()->prepare($req);
                $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
                $stmt->bindValue(":id_lesson", $lessonId, PDO::PARAM_INT);
                $stmt->bindValue(':id_formation', $formationId, PDO::PARAM_INT);
                $stmt->bindValue(":status", 'en cours', PDO::PARAM_STR);
                $result = $stmt->execute();
                $stmt->closeCursor();
            }
        }
    }

        // A la mise en ligne d'une formation, ajoute les leçons de cette formations aux étudiants
        public function addLessonsToStudent($lessonsId, $formationId, $studentsId){
            foreach($studentsId as $studentId){
                foreach($lessonsId as $lessonId){
                    $req ="
                    INSERT INTO student_lesson(id_student, id_lesson, id_formation, status) 
                    VALUES(:id_student, :id_lesson, :id_formation, :status)
                    ";
                    $stmt = $this->getBdd()->prepare($req);
                    $stmt->bindValue(":id_student", $studentId, PDO::PARAM_INT);
                    $stmt->bindValue(":id_lesson", $lessonId, PDO::PARAM_INT);
                    $stmt->bindValue(':id_formation', $formationId, PDO::PARAM_INT);
                    $stmt->bindValue(":status", 'en cours', PDO::PARAM_STR);
                    $result = $stmt->execute();
                    $stmt->closeCursor();
                }
            }
            
        }
}