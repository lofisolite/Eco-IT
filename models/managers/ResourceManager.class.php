<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/Resource.class.php');

class ResourceManager extends Bdd
{
    private $resources;

    private function addResource(Resource $resource){
        $this-> resources[] = $resource;
    }

    public function getResources(){
        return $this-> resources;
    }

    // fonctions requêtes bdd
    // charge toutes les ressources
    public function loadResources(){
        $req = "
        SELECT * FROM resource
        ";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $resources = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($resources as $resource){
            $r = new Resource($resource['id'], $resource['title'], $resource['type_mime'], $resource['url'], $resource['id_lesson']);
            $this->addResource($r);
        }
    }
}