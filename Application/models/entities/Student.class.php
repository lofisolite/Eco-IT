<?php

class Student
{
    private int $id;
    private string $pseudo;
    private string $mail;
    private string $password;

    public function __construct(int $id, string $pseudo, string $mail, string $password){
        $this -> id = $id;
        $this -> pseudo = $pseudo;
        $this -> mail = $mail;
        $this -> password = $password;
    }

    public function getId(){ return $this-> id; }

    public function getPseudo(){ return $this -> pseudo; }

    public function getMail(){ return $this-> mail; }

    public function getPassword(){ return $this->password; }

}