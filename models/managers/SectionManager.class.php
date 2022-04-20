<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/Section.class.php');

class SectionManager extends Bdd
{
    private $sections;

    private function addSection(Section $section){
        $this-> sections[] = $section;
    }

    public function getSections(){
        return $this-> sections;
    }

    public function getSectionsByFormation($formationId){

        foreach($this->sections as $section){
            if($section->getFormationId() === $formationId){
                $sections[] = $section;
                // ici tri après selection des sections et avant de retourner le tableau d'objet
            }
        }
        return $sections;
    }

    public function getSectionsIdByFormation($formationId){

        foreach($this->sections as $section){
            if($section->getFormationId() === $formationId){
                $sectionsId[] = $section->getId();
            }
        }
        return $sectionsId;
    }

    public function getSectionById($SectionId){
        foreach($this->sections as $section){
            if($section->getId() === $SectionId){
                return $section;
            }
        }
    }
    
    // fonctions requêtes bdd
    // charge toutes les sections
    public function loadSections(){
        $req = "SELECT * FROM section";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $sections = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($sections as $section){
            $s = new Section($section['id'], $section['title'], $section['position'], $section['lesson_number'], $section['id_formation']);
            $this->addSection($s);
        }
    }

    public function addSectionInBdd($sections){
        
        foreach($sections as $section){
            $req ="
            INSERT INTO section(title, position, lesson_number, id_formation) 
            VALUES(:title, :position, :lesson_number, :id_formation)
            "; 
            $stmt = $this->getBdd()->prepare($req);
            $stmt->bindValue(":title", $section['title'], PDO::PARAM_STR);
            $stmt->bindValue(":position", $section['position'], PDO::PARAM_INT);
            $stmt->bindValue(":lesson_number", $section['nbrLesson'], PDO::PARAM_INT);
            $stmt->bindValue(":id_formation", $section['formationId'], PDO::PARAM_INT);
            $result = $stmt->execute();
            $stmt->closeCursor();
        }
    }

    public function updateSectionPosition($formationId, $sectionsId){
        // tableau d'identifiant de section
        $compteur = 0;
        foreach($sectionsId as $sectionId){
            $compteur++;
            $req = "
            UPDATE section
            SET position = :position
            WHERE id_formation = :id_formation
            AND id = :id_section
            ";
            $stmt = $this -> getBdd()->prepare($req);
            $stmt->bindValue(":position", $compteur, PDO::PARAM_INT);
            $stmt->bindValue(":id_section", $sectionId, PDO::PARAM_INT);
            $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
            $result = $stmt -> execute();
            $stmt->closeCursor();
        }
    }

    public function deleteOneSectionInBdd($sectionId){
        $req ="
        DELETE FROM section 
        WHERE id = :id_section
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

    public function deleteSectionsOfFormationInBdd($formationId){
        $req ="
        DELETE FROM section 
        WHERE id_formation = :id_formation
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if($result === true){
            return true;
        } else {
            die();
        }
    }
}