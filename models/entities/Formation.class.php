<?php

class Formation
{
    private int $id;
    private string $title;
    private string $description;
    private string $picture;
    private $creationDate;
    private int $teacherId;
    private string $onlineStatus;

    public function __construct(int $id, string $title, string $description, string $picture, $creationDate, int $teacherId, string $onlineStatus){
        $this -> id = $id;
        $this -> title = $title;
        $this -> description = $description;
        $this -> picture = $picture;
        $this -> creationDate = $creationDate;
        $this -> teacherId = $teacherId;
        $this -> online = $onlineStatus;
    }

    public function getId(){ return $this-> id; }

    public function getTitle(){ return $this -> title; }

    public function getDescription(){ return $this -> description; }

    public function getPicture(){ return $this -> picture; }

    public function getCreationDate() { return $this -> creationDate; }

    public function getTeacherId(){ return $this -> teacherId; }

    public function getOnlineStatus(){ return $this -> onlineStatus; }
}