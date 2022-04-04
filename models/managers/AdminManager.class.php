<?php

require_once "models/Bdd.class.php";
require_once "models/entities/Admin.class.php";

class AdminManager extends Bdd
{
    private $admins;

    private function addAdmin(Admin $admin){
        $this-> admins[] = $admin;
    }

    public function getAdmins(){
        return $this-> admins;
    }

    public function getAdminsMails(){
        foreach($this->admins as $admin){
            $adminsMails[] = $admin->getMail();
        }
        return $adminsMails;
    }

    public function loadAdmins(){
        $req = "SELECT * FROM admin";
        $stmt = $this -> getBdd()->prepare($req);
        $stmt -> execute();
        $admins = $stmt-> fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        foreach($admins as $admin){
            $a = new Admin($admin['id'], $admin['firstname'], $admin['lastname'], $admin['mail'], $admin['password']);
            $this->addAdmin($a);
        }
    }

    public function getAdminByMail($mail){
        foreach($this->admins as $admin){
                if($admin->getMail() === $mail){
                    return $admin;
                }
            }
        throw new Exception("Problème pour récupérer l'admin avec mail.");
    }

    public function isAdminConnexionValid($mail, $password){
        $admin = $this->getAdminByMail($mail);
        $bddPassword = $admin->getPassword();
        $pass = password_hash($bddPassword, PASSWORD_DEFAULT);
        return password_verify($password, $pass);
    }
}