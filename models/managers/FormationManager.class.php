<?php

require_once "models/Bdd.class.php";
require_once "models/entities/Formation.class.php";

class FormationManager extends Bdd
{
    private $formations;

    private function addFormation(Formation $formation){
        $this-> formations[] = $formation;
    }

    public function getFormations(){
        return $this-> formations;
    }

    public function loadFormation(){
        $req = "SELECT * FROM formation";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $formations = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($formations as $formation){
            $f = new Formation($formation['id'], $formation['title'], $formation['description'], $formation['url_picture'], $formation['creation_date'], $formation['id_teacher'], $formation['online']);
            $this->addFormation($f);
        }
    }
}