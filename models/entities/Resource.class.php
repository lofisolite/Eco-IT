<?php

class Resource
{
    private int $id;
    private string $title;
    private string $typeMime;
    private string $url;
    private int $lessonId;
    private int $fomationId;

    public function __construct(int $id, string $title, string $typeMime, string $url, int $lessonId, int $formationId){
        $this -> id = $id;
        $this -> title = $title;
        $this -> typeMime = $typeMime;
        $this -> url = $url;
        $this -> lessonId = $lessonId;
        $this -> formationId = $formationId;
    }

    public function getId(){ return $this-> id; }

    public function getTitle(){ return $this -> title; }

    public function getTypeMime(){ return $this -> typeMime; }

    public function getUrl(){ return $this-> url; }

    public function getLessonId(){ return $this -> lessonId; }

    public function getFormationId(){ return $this -> formationId;}
    
}