<?php

require_once(ROOT.'/models/managers/AdminManager.class.php');
require_once(ROOT.'/models/managers/StudentManager.class.php');
require_once(ROOT.'/models/managers/TeacherManager.class.php');
require_once(ROOT.'/models/managers/FormationManager.class.php');
require_once(ROOT.'/models/managers/FormationByStudentManager.class.php');


class Controller{
    private $adminManager;
    private $studentManager;
    private $teacherManager;
    private $formationManager;
    private $formationByStudentManager;

    public function __construct(){
        $this->adminManager = new AdminManager();
        $this->studentManager = new StudentManager();
        $this->teacherManager = new TeacherManager();
        $this->formationManager = new FormationManager();
        $this->formationByStudentManager = new FormationByStudentManager;
    }

    public function test(){

    }

    // Page d'accueil
    Public function setHomePage(){
        $this->teacherManager->loadTeachers();
        $this->formationManager->loadLastFormations();
        $formations = $this->formationManager->getLastFormations();

        $formationsTable = [];
            foreach($formations as $formation){
                $teacherId = $formation->getTeacherId();
                $teacher = $this->teacherManager->getTeacherValidateById($teacherId);

                $table = [];
                $table['title'] = $formation-> getTitle();
                $table['picture'] = $formation-> getPicture();
                $table['description'] = $formation-> getDescription();
                $table['firstname'] = $teacher->getFirstname();
                $table['lastname'] = $teacher->getLastname();
                array_push($formationsTable, $table);
            }
        require_once(ROOT.'/views/common/accueil.view.php');
    }

    // Page connexion
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
        require_once(ROOT.'/views/common/connexion.view.php');
    }

    // Page inscription Student
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
        require_once(ROOT.'/views/inscription/student-inscription.view.php');
    }

    // fonction d'ajout d'image
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
    
    // Page d'inscription teacher
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
                                                                        
                                        if($this->teacherManager->addTeacherInBdd($firstname, $lastname, $mail, $password, $pictureProfileURL, $description) === true){
                                            $_SESSION['alert'] = [
                                                "type" => "success",
                                                "msg" => "Votre inscription a été prise en compte, nous vous recontacterons."         
                                                ];
                                        } else {
                                            $_SESSION['alert'] = [
                                                "type" => "danger",
                                                "msg" => "Votre inscription n'a pas put être enregistré, veuillez réessayer."       
                                            ];
                                        }
                                         
                                        header('Location: '. URL .'accueil');

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
        require_once(ROOT.'/views/inscription/teacher-inscription.view.php');
    }

    
    // Espaces
    // Espace admin
    // page accueil espace admin
    public function setAdminEspace(){
        $this->teacherManager->loadTeachers();
        $this->formationManager->loadFormations();

        $formations = $this->formationManager->getFormations();

        $teachersNotValidate = $this->teacherManager->getTeachersNotValidate();
        $teachersValidate = $this->teacherManager->getTeachersValidate();

        if(isset($teachersValidate)){
            foreach($teachersValidate as $teacher){
                $teachersId[] = $teacher->getId();
            }
        }
        
        if(isset($teachersId)){
            $formationsByTeachersId = $this->formationManager->getFormationsByTeachersId($teachersId);
        }
       
        require_once(ROOT.'/views/admin/admin-espace.view.php');
    }

    // Validation d'un formateur par l'admin
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

    // rejet d'un formateur par l'admin
    public function rejectTeacher($teacherId){
        $this->teacherManager->loadTeachers();
        $picture = $this->teacherManager->getTeacherNotValidateById($teacherId)->getPictureProfile();
        if($this->teacherManager->deleteTeacherInBdd($teacherId) === true){
            unlink($picture);
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


    // Espace student
    // page accueil espace student
    public function setStudentEspace($studentId){
        // 3 dernières formations
        $this->formationManager->loadLastFormations();
        $this->teacherManager->loadTeachers();

        $lastFormations = $this->formationManager->getLastFormations();

        $lastFormationsTable = [];
        foreach($lastFormations as $formation){
            $teacherId = $formation->getTeacherId();
            $teacher = $this->teacherManager->getTeacherValidateById($teacherId);

            $table1 = [];
            $table1['title'] = $formation-> getTitle();
            $table1['picture'] = $formation-> getPicture();
            $table1['description'] = $formation-> getDescription();
            $table1['firstname'] = $teacher->getFirstname();
            $table1['lastname'] = $teacher->getLastname();
            array_push($lastFormationsTable, $table1);
        }

        // formations en cours
        $this->formationManager->loadFormations();
        $this->formationByStudentManager->loadformationsByStudent($studentId);
        $formationsStarted = $this->formationByStudentManager->getFormationsByStudentStarted();
        
        $startedFormationsTable = [];
        if(isset($formationsStarted)){
            foreach($formationsStarted as $formationByStudent){

                $formationId = $formationByStudent->getFormationId();
                $formation = $this->formationManager->getFormationById($formationId);
                $teacherId = $formation->getTeacherId();
                $teacher = $this->teacherManager->getTeacherValidateById($teacherId);

                $table2 = [];
                $table2['title'] = $formation-> getTitle();
                $table2['picture'] = $formation-> getPicture();
                $table2['description'] = $formation-> getDescription();
                $table2['firstname'] = $teacher->getFirstname();
                $table2['lastname'] = $teacher->getLastname();
                $table2['progression'] = $formationByStudent->getProgression();
                array_push($startedFormationsTable, $table2);
            }
        }

        // formations finies
        $formationsFinished = $this->formationByStudentManager->getFormationsByStudentFinished();

        $finishedFormationsTable = [];
        if(isset($formationsFinished)){
            foreach($formationsFinished as $formationByStudent){
                $formationId = $formationByStudent->getFormationId();
                $formation = $this->formationManager->getFormationById($formationId);
                $teacherId = $formation->getTeacherId();
                $teacher = $this->teacherManager->getTeacherValidateById($teacherId);

                $table3 = [];
                $table3['title'] = $formation-> getTitle();
                $table3['picture'] = $formation-> getPicture();
                $table3['description'] = $formation-> getDescription();
                $table3['firstname'] = $teacher->getFirstname();
                $table3['lastname'] = $teacher->getLastname();
                array_push($finishedFormationsTable, $table3);
            }
        }

        require_once(ROOT.'/views/student/student-espace.view.php');
    }

    // page formation student
    public function studentFormation($formationId, $studentId){

        require_once(ROOT.'/views/student/student-formation-details.view.php');
    }
    

    // Espace teacher
    // page accueil espace teacher
    public function setTeacherEspace($teacherId){
       
        require_once(ROOT.'/views/teacher/teacher-espace.view.php');
    }


    
    // fonctions ajax
    // fonction ajax recherche formation par mot clef - Page d'accueil + espace étudiant
    public function ajaxSearchFormation($recherche){
        $this->teacherManager->loadTeachers();
        $this->formationManager->loadFormationsByWord($recherche);
        $formations = $this->formationManager->getFormationsByWord();

        $formationTable = [];
        if(isset($formations)){
            foreach($formations as $formation){
                $teacherId = $formation->getTeacherId();
                $teacher = $this->teacherManager->getTeacherValidateById($teacherId);

                $table = [];
                $table['title'] = $formation-> getTitle();
                $table['picture'] = $formation-> getPicture();
                $table['description'] = $formation-> getDescription();
                $table['firstname'] = $teacher->getFirstname();
                $table['lastname'] = $teacher->getLastname();
                array_push($formationTable, $table);
            }
        }
        return $formationTable;
    }

    public function ajaxLastFormations(){

    $this->teacherManager->loadTeachers();
    $this->formationManager->loadLastFormations();
    $formations = $this->formationManager->getLastFormations();

    $formationsTable = [];
        foreach($formations as $formation){
            $teacherId = $formation->getTeacherId();
            $teacher = $this->teacherManager->getTeacherValidateById($teacherId);

            $table = [];
            $table['title'] = $formation-> getTitle();
            $table['picture'] = $formation-> getPicture();
            $table['description'] = $formation-> getDescription();
            $table['firstname'] = $teacher->getFirstname();
            $table['lastname'] = $teacher->getLastname();
            array_push($formationsTable, $table);
        }
        return $formationsTable;
    }
}


