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

    // donne un identifiant de formation, récupére toutes les lessons de cette formation.
    public function getLessonsByFormation($formationId){
        foreach($this->lessons as $lesson){
            if($lesson->getFormationId() === $formationId){
                $lessons[] = $lesson;
            }
        }
        return $lessons;
    }

        // donne un identifiant de formation, récupére toutes les lessons de cette formation.
        public function getLessonsIdByFormation($formationId){
            foreach($this->lessons as $lesson){
                if($lesson->getFormationId() === $formationId){
                    $lessons[] = $lesson->getId();
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

    public function addLessonInBdd($lesson){
        $req ="
        INSERT INTO lesson(title, content, url_video, position, id_formation, id_section) 
        VALUES(:title, :content, :url_video, :position, :id_formation, :id_section)
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":title", $lesson['title'], PDO::PARAM_STR);
        $stmt->bindValue(":content", $lesson['content'], PDO::PARAM_STR);
        $stmt->bindValue(":url_video", $lesson['video'], PDO::PARAM_STR);
        $stmt->bindValue(":position", $lesson['position'], PDO::PARAM_INT);
        $stmt->bindValue(":id_formation", $lesson['formationId'], PDO::PARAM_INT);
        $stmt->bindValue(":id_section", $lesson['sectionId'], PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result === false){
            throw new Exception('l\'insertion des lessons en base de donnés n\'a pas fonctionné');
        }
    }

    public function updateLessonInBdd($lesson){
        $req ="
        UPDATE lesson
        SET title = :title, 
        content = :content, 
        url_video = :url_video
        WHERE id_formation = :id_formation
        AND id_section = :id_section
        AND position = :position
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":title", $lesson['title'], PDO::PARAM_STR);
        $stmt->bindValue(":content", $lesson['content'], PDO::PARAM_STR);
        $stmt->bindValue(":url_video", $lesson['video'], PDO::PARAM_STR);
        $stmt->bindValue(":position", $lesson['position'], PDO::PARAM_INT);
        $stmt->bindValue(":id_formation", $lesson['formationId'], PDO::PARAM_INT);
        $stmt->bindValue(":id_section", $lesson['sectionId'], PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result === true){
            return true;
        } else {
            die();
        }
    }

    public function deleteLessonOfSectionInBdd($sectionId){
        $req ="
        DELETE FROM lesson 
        WHERE id_section = :id_section
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_section", $sectionId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result === true){
            return true;
        } else {
            die();
        }
    }

    public function deletelessonsOfFormationInBdd($formationId){
        $req ="
        DELETE FROM lesson 
        WHERE id_formation = :id_formation
        "; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
      $result = $stmt->execute();
      $stmt->closeCursor();

      return $result;
    }
}