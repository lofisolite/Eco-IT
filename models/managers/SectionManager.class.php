<?php

require_once "models/Bdd.class.php";
require_once "models/entities/Section.class.php";

class SectionManager extends Bdd
{
    private $sections;

    private function addSection(Section $section){
        $this-> sections[] = $section;
    }

    public function getSections(){
        return $this-> sections;
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