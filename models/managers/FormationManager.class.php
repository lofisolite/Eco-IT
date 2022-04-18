<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/Formation.class.php');

class FormationManager extends Bdd
{
    private $allFormations;
    private $formationsOnline;
    private $lastFormations;
    private $formationsByWord;

    private function addFormation(Formation $formation){
        $this-> allFormations[] = $formation;
    }

    public function getFormations(){
        return $this-> allFormations;
    }

    private function addFormationOnline(Formation $formation){
        $this-> formationsOnline[] = $formation;
    }

    public function getFormationsOnline(){
        return $this-> formationsOnline;
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
    public function getFormationById($formationId){
        foreach($this->allFormations as $formation){
            if($formation->getId() === $formationId){
                return $formation;
            }
        }
    }

    // reçoit un identifiant de formateur, donne toutes ses formations en ligne.
    public function getFormationsOnlineByTeacherId($teacherId){
            foreach($this->formationsOnline as $formation){
                if($formation->getTeacherId() === $teacherId){
                    $formationsOnlineByTeacher[] = $formation;
                }
            }
            return $formationsOnlineByTeacher;
    }
    
    // reçoit un identifiant de formateur, donne toutes ses formations hors ligne.
    public function getformationsNotOnlineByTeacherId($teacherId){
        foreach($this->allFormations as $formation){
            if($formation->getTeacherId() === $teacherId && $formation->getOnlineStatus() === 'non'){
                $formationsNotOnlineByTeacher[] = $formation;
            }
        }
        return $formationsNotOnlineByTeacher;
    }

    // reçoit un identifiant de formateur, donne tous les identifiants de ses formations hors ligne
    public function getformationsNotOnlineIdByTeacherId($teacherId){
        foreach($this->allFormations as $formation){
            if($formation->getTeacherId() === $teacherId && $formation->getOnlineStatus() === 'non'){
                $formationsNotOnlineIdByTeacher[] = $formation->getId();
            }
        }
        return $formationsNotOnlineIdByTeacher;
    }

        // reçoit un identifiant de formateur, donne toutes ses formations sans distinction.
        public function getformationsByTeacherId($teacherId){
            foreach($this->allFormations as $formation){
                if($formation->getTeacherId() === $teacherId){
                    $formationsByTeacher[] = $formation;
                }
            }
            return $formationsByTeacher;
        }

    // retourne les identifiants des formations en ligne
    public function getFormationsOnlineId(){
        foreach($this->formationsOnline as $formation){
            $formationsOnlineId[] = $formation->getId();
        }
        return $formationsOnlineId;
    }

    // donne un identifiant de formateur, retourne l'identifiant de sa dernière formation enregistré.
    public function getLastFormationIdByTeacher($teacherId){
        $formationsTable = $this->getformationsByTeacherId($teacherId);
        foreach($formationsTable as $formation){
            $formations[] = $formation->getId();
        }
        $lastFormation = end($formations);
        return $lastFormation;
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

            if($f->getOnlineStatus() === 'oui'){
                $this->addFormationOnline($f);
                $this->addFormation($f);
            } else if($f->getOnlineStatus() === 'non'){
                $this->addFormation($f);
            }
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

    public function UpdateFormationOnline($formationId, $creationDate){
        $req = "
        UPDATE formation
        SET online = 'oui',
        creation_date = :date
        WHERE id = :id
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt->bindValue(":id", $formationId, PDO::PARAM_INT);
        $stmt->bindValue(":date", $creationDate, PDO::PARAM_STR);
        $result = $stmt -> execute();
        $stmt->closeCursor();
        
        return $result;
    }

    public function addFormationInBdd($title, $description, $picture, $teacherId){
        $req ="
        INSERT INTO formation(title, description, url_picture, id_teacher, online) 
        VALUES(:title, :description, :url_picture, :id_teacher, :online)
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":url_picture", $picture, PDO::PARAM_STR);
        $stmt->bindValue(":id_teacher", $teacherId, PDO::PARAM_INT);
        $stmt->bindValue(":online", 'non', PDO::PARAM_STR);
        $result = $stmt->execute();
        $stmt->closeCursor();

        return $result;
    }

    public function updateFormationInBdd($formationId, $title, $description, $picture){
        $req ="
        UPDATE formation
        SET title = :title, 
        description = :description, 
        url_picture = :url_picture
        WHERE id = :id_formation
        "; 
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":title", $title, PDO::PARAM_STR);
        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":url_picture", $picture, PDO::PARAM_STR);
        $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
        $result = $stmt->execute();
        $stmt->closeCursor();

        return $result;

    }

        

    public function deleteFormationInBdd($formationId){
        $req ="
        DELETE FROM formation WHERE id = :id_formation
        "; 
      $stmt = $this->getBdd()->prepare($req);
      $stmt->bindValue(":id_formation", $formationId, PDO::PARAM_INT);
      $result = $stmt->execute();
      $stmt->closeCursor();

      return $result;
    }
}