<?php

require_once "models/Bdd.class.php";
require_once "models/entities/lesson.class.php";

class LessonManager extends Bdd
{
    private $lessons;

    private function addLesson(Lesson $lesson){
        $this-> lessons[] = $lesson;
    }

    public function getLessons(){
        return $this-> lessons;
    }

    public function loadLessons(){
        $req = "SELECT * FROM lesson";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $lessons = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($lessons as $lesson){
            $l = new Lesson($lesson['id'], $lesson['title'], $lesson['content'], $lesson['url_video'], $lesson['position'], $lesson['id_formation'], $lesson['id_section']);
            $this->addLesson($l);
        }
    }
}