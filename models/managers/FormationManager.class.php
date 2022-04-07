<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/Formation.class.php');

class FormationManager extends Bdd
{
    private $formations;
    private $lastFormations;
    private $formationsByWord;

    private function addFormation(Formation $formation){
        $this-> formations[] = $formation;
    }

    public function getFormations(){
        return $this-> formations;
    }

    private function addLastFormation(Formation $formation){
        $this-> lastFormations[] = $formation;
    }

    public function getLastFormations(){
        return $this-> lastFormations;
    }

    private function addFormationByWord(Formation $formation){
        $this -> formationsByWord[] = $formation;
    }

    public function getFormationsByWord(){
        return $this-> formationsByWord;
    }

    // reçoit un identifiant de formation, récupère la formation
    public function getFormationById(int $formationId){
        foreach($this->formations as $formation){
            if($formation->getId() === $formationId){
                return $formation;
            }
        }
    }

    // reçoit un identifiant de formateur, donne toutes ses formations.
    public function getFormationsByTeacherId(int $teacherId){
        foreach($this->formations as $formation){
            if($formation->getTeacherId() === $teacherId){
                $formationsByTeacher[] = $formation;
            }
        }
        return $formationsByTeacher;
    }

    // reçoit un tableau d'identifiant de formateurs, renvoie un tableau de tableau de formations.
    public function getFormationsByTeachersId(array $teachersId){
        foreach($teachersId as $teacherId){
            $formationsByTeachers[] = $this->getFormationsByTeacherId($teacherId);
        }
        return $formationsByTeachers;
    }

    // fonctions requêtes bdd
    // charge toutes les formations
    public function loadFormations(){
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

    // charge les trois dernières formations en fonction de la date de création.
    public function loadLastFormations(){
        $req = "
        SELECT * FROM formation
        WHERE online = 'oui'
        ORDER BY creation_date DESC
        LIMIT 3
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $result = $stmt -> execute();
        $formations = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        
        foreach($formations as $formation){
            $f = new Formation($formation['id'], $formation['title'], $formation['description'], $formation['url_picture'], $formation['creation_date'], $formation['id_teacher'], $formation['online']);
            $this->addLastFormation($f);
        }
        
        if($result === false){
            die();
        }
    }

        // charge les trois dernières formations en fonction de la date de création.
        public function loadFormationsByWord($recherche){
            $req = "
            SELECT * FROM formation
            WHERE online = 'oui'
            AND description LIKE :word
            ORDER BY creation_date DESC
            ";
            $stmt = $this -> getBdd()->prepare($req);
            $stmt->bindValue(":word", '%'.$recherche.'%', PDO::PARAM_STR);
            $result = $stmt -> execute();
            $formations = $stmt-> fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            
            foreach($formations as $formation){
                $f = new Formation($formation['id'], $formation['title'], $formation['description'], $formation['url_picture'], $formation['creation_date'], $formation['id_teacher'], $formation['online']);
                $this->addFormationByWord($f);
            }

            if($result === false){
                die();
            }
        }
}