<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/Lesson.class.php');

class LessonManager extends Bdd
{
    private $lessons;

    private function addLesson(Lesson $lesson){
        $this-> lessons[] = $lesson;
    }

    public function getLessons(){
        return $this-> lessons;
    }

    public function getLessonById($lessonId){
        foreach($this->lessons as $lesson){
            if($lesson->getId() === $lessonId){
                return $lesson;
            }
        }
    }

    public function getLessonsBySection($sectionId){
        foreach($this->lessons as $lesson){
            if($lesson->getSectionId() === $sectionId){
                $lessons[] = $lesson;
            }
        }
        return $lessons;
    }

    public function getLessonsByFormation($formationId){
        foreach($this->lessons as $lesson){
            if($lesson->getFormationId() === $formationId){
                $lessons[] = $lesson;
            }
        }
        return $lessons;
    }

    // fonctions requêtes bdd
    // charge toutes les lessons
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