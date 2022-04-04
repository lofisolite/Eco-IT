<?php

require_once "models/managers/AdminManager.class.php";
require_once "models/managers/StudentManager.class.php";
require_once "models/managers/TeacherManager.class.php";
require_once "models/managers/FormationManager.class.php";

class Controleur{
    private $adminManager;
    private $studentManager;
    private $teacherManager;
    private $formationManager;

    public function __construct(){
        $this->adminManager = new AdminManager();
        $this->studentManager = new StudentManager();
        $this->teacherManager = new TeacherManager();
        $this->formationManager = new FormationManager();
    }

    public function test(){

        require_once "views/test.views.php";
    }

    public function toLogin()
    {
        if(verifyAccessAdmin()){
            header("location: adminEspace");
        } else if(verifyAccessStudent()){
            header("location: studentEspace");
        } else if(verifyAccessTeacher()){
            header("location: teacherEspace");
        }
        $this -> adminManager -> loadAdmins();
        $this->studentManager -> loadStudents();
        $this -> teacherManager -> loadTeachers();
        $essai = $this->studentManager->getStudents();
        
        $adminMails = $this->adminManager->getAdminsMails();
        $studentMails = $this->studentManager->getStudentsMails();
        $teacherMails = $this->teacherManager->getTeachersValidateMails();
        print_r($teacherMails);
        $alert = "";
        if(isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['password']) && !empty($_POST['password'])){  
            $mail = SecureData($_POST['mail']);
            $password = secureData($_POST['password']);

            if(in_array($mail, $adminMails)){
                if($this->adminManager->isAdminConnexionValid($mail, $password)){
                    $admin = $this->adminManager->getAdminByMail($mail);
                    $adminId = $admin->getId();
                    $adminFirstname = $admin->getFirstname();

                    $_SESSION['access'] = 'admin';
                    $_SESSION['id'] = $adminId;
                    $_SESSION['fn'] = $adminFirstname;
                    genereCookieSession();
                    header("location: adminEspace");
                } else {
                    $alert = "mot de passe non valide";
                }
            } else if(in_array($mail, $studentMails)){
                if($this->studentManager->isStudentConnexionValid($mail, $password)){
                    $student = $this->studentManager->getStudentByMail($mail);
                    $studentId = $student->getId();
                    $studentPseudo = $student->getPseudo();

                    $_SESSION['access'] = 'student';
                    $_SESSION['id'] = $studentId;
                    $_SESSION['ps'] = $studentPseudo;

                    genereCookieSession();
                    header("location: studentEspace");
                } else {
                    $alert = "mot de passe non valide";
                }
            } else if(in_array($mail, $teacherMails)){ 
                if($this->teacherManager->isTeacherValidateConnexionValid($mail, $password)){
                    $teacher = $this->teacherManager->getTeacherValidateByMail($mail);
                    $teacherId = $teacher->getId();
                    $teacherFirstname = $teacher->getFirstname();
                    $teacherLastname = $teacher->getLastname();

                    $_SESSION['access'] = 'teacher';
                    $_SESSION['id'] = $teacherId;
                    $_SESSION['fn'] = $teacherFirstname;
                    $_SESSION['ln'] = $teacherLastname;

                    genereCookieSession();
                    header("location: teacherEspace");
                } else {
                    $alert = "mot de passe non valide - teacher";
                }
            } else {
                $alert = "mot de passe ou mail non valide - teacher.";
            }
        }
        require_once "views/common/connexion.view.php";
    }

    public function signUpStudent(){
        $this->studentManager->loadStudents();
        $pseudoList = $this->studentManager->getStudentsPseudos();
        $essai = $pseudoList;

        $error = '';
        if(isset($_POST['pseudo']) && !empty($_POST['pseudo']) 
        && isset($_POST['mail']) && !empty($_POST['mail']) 
        && isset($_POST['password']) && !empty($_POST['password'])){
            $pseudo = secureData($_POST['pseudo']);
            $mail = secureData($_POST['mail']);
            $passwordtmp = secureData($_POST['password']);

            if(verifyPseudo($pseudo, $pseudoList) === true){
                if(verifyMail($mail) === true){
                    if(verifyPassword($passwordtmp) === true){
                        $password = password_hash($passwordtmp, PASSWORD_DEFAULT);
                        $this->studentManager->addStudentInBdd($pseudo, $mail, $password);
                        
                        $student = $this->studentManager->getStudentByMail($mail);
                        $studentId = $student->getId();
                        $_SESSION['access'] = 'student';
                        $_SESSION['id'] = $studentId;
                        genereCookieSession();
                        header('Location: '. URL .'studentEspace');
                    } else {
                       $error = verifyPassword($passwordtmp);
                    }
                } else {
                   $error = verifyMail($mail);
                }

            } else {
                $error = verifyPseudo($pseudo, $pseudoList);
            }

        } else {
            $error = '';
        }

        require_once "views/inscription/student-inscription.view.php";
    }

    public function ajoutImageFile($image, $lastname, $dir){
        $random = rand(0,999);
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageFile = $dir."_".$random.$lastname.".".$extension;
        if(!move_uploaded_file($image['tmp_name'], $imageFile)){
            return false;
        } else {
            return $imageFile;
        }
    }
    
    public function signUpTeacher(){
        
        $error = '';
        if(isset($_POST['firstname']) && !empty($_POST['firstname']) 
        && isset($_POST['lastname']) && !empty($_POST['lastname'])
        && isset($_POST['mail']) && !empty($_POST['mail']) 
        && isset($_POST['password']) && !empty($_POST['password'])
        && isset($_FILES['pictureProfile']) && !empty($_FILES['pictureProfile'])
        && isset($_POST['description']) && !empty($_POST['description'])){
            $firstname = secureData($_POST['firstname']);
            $lastname = secureData($_POST['lastname']);
            $mail = secureData($_POST['mail']);
            $passwordtmp = secureData($_POST['password']);
            $pictureProfile = $_FILES['pictureProfile'];
            $description = secureData($_POST['description']);
            
            if(verifyName($firstname) === true){
                if(verifyName($lastname) === true){
                    if(verifyPicture($pictureProfile) === true){
                        if(verifyDescription($description) === true){
                            if(verifyMail($mail) === true){
                                if(verifyPassword($passwordtmp) === true){
                                    
                                    $dir = 'images/teacher/';
                                    if(($pictureProfileURL = $this->ajoutImageFile($pictureProfile, $lastname, $dir)) !== false){

                                        $password = password_hash($passwordtmp, PASSWORD_DEFAULT);
                                                                        
                                        $this->teacherManager->addTeacherInBdd($firstname, $lastname, $mail, $password, $pictureProfileURL, $description);
                                                                        
                                        $this->teacherManager->loadTeachers();
                                        $teacher = $this->teacherManager->getTeacherNotValidateByMail($mail);
                                        $teacherId = $teacher->getId();
                                        $teacherFirstname = $teacher->getFirstname();
                                        $teacherLastname = $teacher->getLastname();

                                        $_SESSION['access'] = 'teacher';
                                        $_SESSION['id'] = $teacherId;
                                        $_SESSION['fn'] = $teacherFirstname;
                                        $_SESSION['ln'] = $teacherLastname;
                                        
                                        genereCookieSession();
                                        header('Location: '. URL .'teacherEspace');

                                    } else {
                                        $error = 'Photo de profil : Il y a un problème avec l\'ajout d\'image, veuillez réessayer';
                                    }
                                } else {
                                $error = verifyPassword($passwordtmp);
                                }
                            } else {
                            $error = verifyMail($mail);
                            }
                        } else {
                            $error = verifyDescription($description);
                        }
                    } else {
                        $error = verifyPicture($pictureProfile);
                    }
                } else {
                    $error = verifyName($lastname);
                }
            } else {
                $error = verifyName($firstname);
            }
        } else {
            $error = '';
        }
        
        require_once "views/inscription/teacher-inscription.view.php";
    }

    public function setStudentEspace(){

        
        require_once "views/student/student-espace.view.php";
    }

    public function setAdminEspace(){
        $this->teacherManager->loadTeachers();
        $this->formationManager->loadFormations();

        $teachersNotValidate = $this->teacherManager->getTeachersNotValidate();
        $teachersValidate = $this->teacherManager->getTeachersValidate();

        foreach($teachersValidate as $teacher){
            $teachersId[] = $teacher->getId();
        }
        
        $formationsByTeachersId = $this->formationManager->getFormationsByTeachersId($teachersId);
        
        require_once "views/admin/admin-espace.view.php";
    }

    public function validateTeacher($teacherId){
        if($this->teacherManager->validateTeacherInBdd($teacherId) === true){
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Le formateur a été validé."         
                ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "Le formateur n'a pas put être validé."       
            ];
        }
    
            header('Location: '. URL . "adminEspace");
    }

    public function rejectTeacher($teacherId){
        if($this->teacherManager->deleteTeacherInBdd($teacherId) === true){
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Le formateur a bien été supprimé de la base de donnée."         
                ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "Le formateur n'a pas put être supprimé de la base de donnée."       
            ];
        }
            header('Location: '. URL . "adminEspace");
    }
}