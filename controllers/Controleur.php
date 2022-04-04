<?php

require_once "models/managers/AdminManager.class.php";
require_once "models/managers/StudentManager.class.php";
require_once "models/managers/TeacherManager.class.php";

class Controleur{
    private $adminManager;
    private $studentManager;
    private $teacherManager;

    public function __construct(){
        $this->adminManager = new AdminManager();
        $this->studentManager = new StudentManager();
        $this->teacherManager = new TeacherManager();
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

        $alert = "";
        if(isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['password']) && !empty($_POST['password'])){  
            $mail = SecureData($_POST['mail']);
            $password = secureData($_POST['password']);

            if(in_array($mail, $adminMails)){
                if($this->adminManager->isAdminConnexionValid($mail, $password)){
                    $admin = $this->adminManager->getAdminByMail($mail);
                    $adminId = $admin->getId();

                    $_SESSION['access'] = 'admin';
                    $_SESSION['id'] = $adminId;
                    genereCookieSession();
                    header("location: adminEspace");
                } else {
                    $alert = "mot de passe non valide";
                }
            } else if(in_array($mail, $studentMails)){
                if($this->studentManager->isStudentConnexionValid($mail, $password)){
                    $student = $this->studentManager->getStudentByMail($mail);
                    $studentId = $student->getId();

                    $_SESSION['access'] = 'student';
                    $_SESSION['id'] = $studentId;
                    genereCookieSession();
                    header("location: studentEspace");
                } else {
                    $alert = "mot de passe non valide";
                }
            } else if(in_array($mail, $teacherMails)){ 
                if($this->teacherManager->isTeacherValidateConnexionValid($mail, $password)){
                    $teacher = $this->teacherManager->getTeacherValidateByMail($mail);
                    $teacherId = $teacher->getId();

                    $_SESSION['access'] = 'teacher';
                    $_SESSION['id'] = $teacherId;
                    genereCookieSession();
                    header("location: teacherEspace");
                } else {
                    $alert = "mot de passe non valide - php";
                }
            } else {
                $alert = "mot de passe ou mail non valide.";
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
                                        $_SESSION['access'] = 'teacher';
                                        $_SESSION['id'] = $teacherId;

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
}