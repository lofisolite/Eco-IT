<?php

class Resource
{
    private int $id;
    private string $title;
    private string $typeMime;
    private string $url;
    private int $lessonId;

    public function __construct(int $id, string $title, string $typeMime, string $url, int $lessonId){
        $this -> id = $id;
        $this -> title = $title;
        $this -> typeMime = $typeMime;
        $this -> url = $url;
        $this -> lessonId = $lessonId;
    }

    public function getId(){ return $this-> id; }

    public function getTitle(){ return $this -> title; }

    public function getTypeMime(){ return $this -> typeMime; }

    public function getUrl(){ return $this-> url; }

    public function getLessonId(){ return $this -> lessonId; }
}