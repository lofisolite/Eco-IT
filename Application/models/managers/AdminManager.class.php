<?php

require_once(ROOT.'/models/Bdd.class.php');
require_once(ROOT.'/models/entities/Admin.class.php');

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

    // fonctions requêtes bdd
    // charge tous les admins
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

    // récupére l'admin avec son mail - 
    public function getAdminByMail($mail){
        foreach($this->admins as $admin){
                if($admin->getMail() === $mail){
                    return $admin;
                }
            }
        throw new Exception("Problème pour récupérer l'admin avec mail.");
    }

    // vérifie que l'admin fournit les bons identifiants pour se connecter.
    public function isAdminConnexionValid($mail, $password){
        $admin = $this->getAdminByMail($mail);
        $bddPassword = $admin->getPassword();
        return password_verify($password, $bddPassword);
    }
}