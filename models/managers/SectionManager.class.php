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

    public function tri($a, $b){

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
            $s = new Section($section['id'], $section['title'], $section['position'], $section['id_formation']);
            $this->addSection($s);
        }
    }
}