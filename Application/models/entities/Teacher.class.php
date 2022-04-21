<?php

class Teacher
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $mail;
    private string $password;
    private string $pictureProfile;
    private string $description;
    private string $validation;

    public function __construct(int $id, string $firstname, string $lastname, string $mail, string $password, string $pictureProfile, string $description, string $validation){
        $this -> id = $id;
        $this -> firstname = $firstname;
        $this -> lastname = $lastname;
        $this -> mail = $mail;
        $this -> password = $password;
        $this -> pictureProfile = $pictureProfile;
        $this -> description = $description;
        $this -> validation = $validation;
    }

    public function getId(){ return $this-> id; }

    public function getFirstname(){ return $this -> firstname; }

    public function getLastname(){ return $this -> lastname; }

    public function getMail(){ return $this-> mail; }

    public function getPassword(){ return $this -> password; }

    public function getPictureProfile(){ return $this -> pictureProfile; }

    public function getDescription(){ return $this -> description;}
    
    public function getValidation(){ return $this -> validation; }


}