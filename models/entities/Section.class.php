<?php

class Section
{
    private int $id;
    private string $title;
    private int $position;
    private int $lessonNumber;
    private int $formationId;

    public function __construct(int $id, string $title, int $position, int $lessonNumber, int $formationId){
        $this -> id = $id;
        $this -> title = $title;
        $this -> position = $position;
        $this -> lessonNumber = $lessonNumber;
        $this -> formationId = $formationId;
    }

    public function getId(){ return $this-> id; }

    public function getTitle(){ return $this -> title; }

    public function getPosition(){ return $this -> position; }

    public function getLessonNumber() { return $this -> lessonNumber; }

    public function getFormationId(){ return $this -> formationId; }
}