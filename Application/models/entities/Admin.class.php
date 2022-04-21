<?php

class Admin
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $mail;
    private string $password;

    public function __construct(int $id, string $firstname, string $lastname, string $mail, string $password){
        $this -> id = $id;
        $this -> firstname = $firstname;
        $this -> lastname = $lastname;
        $this -> mail = $mail;
        $this -> password = $password;
    }

    public function getId(){ return $this-> id; }

    public function getFirstname(){ return $this -> firstname; }

    public function getLastname(){ return $this -> lastname; }

    public function getMail(){ return $this-> mail; }

    public function getPassword(){ return $this->password; }

}