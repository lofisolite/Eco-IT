<?php

class Section
{
    private int $id;
    private string $title;
    private int $position;
    private int $formationId;

    public function __construct(int $id, string $title, int $position, int $formationId){
        $this -> id = $id;
        $this -> title = $title;
        $this -> position = $position;
        $this -> formationId = $formationId;
    }

    public function getId(){ return $this-> id; }

    public function getTitle(){ return $this -> title; }

    public function getPosition(){ return $this -> position; }

    public function getFormationId(){ return $this -> formationId; }
}