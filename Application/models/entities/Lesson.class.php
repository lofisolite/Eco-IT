<?php

class Lesson
{
    private int $id;
    private string $title;
    private string $content;
    private string $video;
    private int $position;
    private int $formationId;
    private int $sectionId;

    public function __construct(int $id, string $title, string $content, string $video, int $position, int $formationId, int $sectionId){
        $this -> id = $id;
        $this -> title = $title;
        $this -> content = $content;
        $this -> video = $video;
        $this -> position = $position;
        $this -> formationId = $formationId;
        $this -> sectionId = $sectionId;
    }

    public function getId(){ return $this-> id; }

    public function getTitle(){ return $this -> title; }

    public function getContent(){ return $this -> content; }

    public function getVideo(){ return $this-> video; }

    public function getPosition(){ return $this -> position; }

    public function getFormationId(){ return $this -> formationId; }

    public function getSectionId(){ return $this -> sectionId; }
}