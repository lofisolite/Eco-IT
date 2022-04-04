<?php

require_once "models/Bdd.class.php";
require_once "models/entities/LessonByStudent.class.php";

class LessonByStudentManager extends Bdd
{
    private $lessonsByStudent;

    private function addLessonByStudent(LessonByStudent $lessonByStudent){
        $this-> lessonsByStudent[] = $lessonByStudent;
    }

    public function getLessonsByStudent(){
        return $this-> lessonsByStudent;
    }

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
}