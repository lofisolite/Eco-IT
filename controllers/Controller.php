<?php

require_once(ROOT.'/models/managers/AdminManager.class.php');
require_once(ROOT.'/models/managers/StudentManager.class.php');
require_once(ROOT.'/models/managers/TeacherManager.class.php');
require_once(ROOT.'/models/managers/FormationManager.class.php');
require_once(ROOT.'/models/managers/SectionManager.class.php');
require_once(ROOT.'/models/managers/LessonManager.class.php');
require_once(ROOT.'/models/managers/ResourceManager.class.php');
require_once(ROOT.'/models/managers/FormationByStudentManager.class.php');
require_once(ROOT.'/models/managers/LessonByStudentManager.class.php');

class Controller{
    private $adminManager;
    private $studentManager;
    private $teacherManager;
    private $formationManager;
    private $sectionManager;
    private $lessonManager;
    private $resourceManager;
    private $formationByStudentManager;
    private $lessonByStudentManager;

    public function __construct(){
        $this->adminManager = new AdminManager();
        $this->studentManager = new StudentManager();
        $this->teacherManager = new TeacherManager();
        $this->formationManager = new FormationManager();
        $this->sectionManager = new SectionManager();
        $this->lessonManager = new LessonManager();
        $this->resourceManager = new ResourceManager();
        $this->formationByStudentManager = new FormationByStudentManager;
        $this->lessonByStudentManager = new LessonByStudentManager;
    }



    public function test(){
    

        require_once(ROOT.'\views\common\test.view.php');
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
            header("Location: ". URL . "adminEspace");
        } else if(verifyAccessStudent()){
            header("Location: ". URL . "studentEspace");
        } else if(verifyAccessTeacher()){
            header("Location: ". URL . "teacherEspace");
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
                    header("Location: ". URL . "adminEspace");
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
                    header("Location: ". URL . "studentEspace");
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
                    header("Location: ". URL . "teacherEspace");
                } else {
                    $alert = "mot de passe non valide - teacher";
                }
            } else {
                $alert = "mot de passe ou mail non valide - teacher.";
            }
        }
        require_once(ROOT.'/views/common/connexion.view.php');
    }

    // student : page d'inscription
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
    
    // teacher - page d'inscription
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
                                    
                                    $dir = 'public/images/teacher/';
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

    // transformation URL video youtube pour être intégré dans la page
    public function videoYoutubeEmbed($videoYT){
        if( !empty($videoYT))
        {
            $videoYT = str_replace('youtu.be/', 'www.youtube.com/embed/', $videoYT);
            $videoYT = str_replace('www.youtube.com/watch?v=', 'www.youtube.com/embed/', $videoYT);
        }
        // -----------------
        return $videoYT;
    }

    
    // Espace admin
    // admin : page d'accueil
    public function setAdminEspace(){
        $this->teacherManager->loadTeachers();
        $this->formationManager->loadFormations();

        $teachersNotValidate = $this->teacherManager->getTeachersNotValidate();
        $teachersValidate = $this->teacherManager->getTeachersValidate();

        if(isset($teachersValidate)){
            $teachersValidateTable = [];
            foreach($teachersValidate as $teacher){
                $table2['id'] = $teacher->getId();
                $table2['firstname'] = $teacher->getFirstname();
                $table2['lastname'] = $teacher->getLastname();
                $table2['picture'] = $teacher->getPictureProfile();
                $table2['mail'] = $teacher->getMail();
                $table2['description'] = $teacher->getDescription();
                $table2['formations'] = $this->formationManager->getFormationsOnlineByTeacherId($teacher->getId());
                
                array_push($teachersValidateTable, $table2);
            }
        }
        require_once(ROOT.'/views/admin/admin-espace.view.php');
    }


    // admin : Validation d'un formateur par l'admin
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


    // admin : rejet d'un formateur par l'admin
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


    public function adminFormationPage($formationId){
        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();
        $this->resourceManager->loadResources();

        //Si une formation n'existe pas, page d'erreur
        $allFormations = $this->formationManager->getFormationsOnline();
        foreach($allFormations as $formation){
            $allFormationsId[] = $formation->getId();
        }

        if(!in_array($formationId, $allFormationsId)){
            throw new Exception('Cette formation n\'existe pas.');
            }

        // la formation
        $formation = $this->formationManager->getFormationById($formationId);
        // les sections de la formation
        $allSections = $this->sectionManager->getSectionsByFormation($formationId);

        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons pour les boutons "précédent" et "suivant".
        foreach($allLessons as $lesson){
            $lessonsId[] = $lesson->getId();
        }
        $firstLessonId = $lessonsId[0];
        $lastLessonId = end($lessonsId);

        // Le menu de la formation, la première section et la première leçon de la première section
        $menuFormation = [];
        foreach($allSections as $section){
            // titre de la première section
            if($section->getPosition() === 1){
                $firstSectionId = $section->getId();
                $firstSectionTitle = $section->getTitle();
            }
            // la première leçon
            $lessonsFirstSection = $this->lessonManager->getLessonsBySection($firstSectionId);
            foreach($lessonsFirstSection as $lesson){
                if($lesson->getPosition() === 1){
                    $firstLesson = $lesson;
                }
            }
        
            // Elements du menu formation
            $tableMenu['formationId'] = $formationId;
            $tableMenu['sectionTitle'] = $section->getTitle();
            $tableMenu['sectionPosition'] = $section->getPosition();
            $tableMenu['lessons'] = $this->lessonManager->getLessonsBySection($section->getId());
            array_push($menuFormation, $tableMenu);  
        }

        // Elements de l'espace leçon
        $lessonContent['sectionTitle'] = $firstSectionTitle;
        $lessonContent['lessonId'] = $firstLesson->getId();
        $lessonContent['lessonTitle'] = $firstLesson->getTitle();
        $lessonContent['lessonvideo'] = $this->videoYoutubeEmbed($firstLesson->getvideo());
        $lessonContent['lessonContent'] = $firstLesson->getContent();

        require_once(ROOT.'/views/admin/admin-formation-details.view.php');
    }

    public function adminLessonFormationPage($formationId, $lessonId){

        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();
        $this->resourceManager->loadResources();

        //Si une formation n'existe pas, page d'erreur
        $allFormations = $this->formationManager->getFormationsOnline();
        foreach($allFormations as $formation){
            $allFormationsId[] = $formation->getId();
        }

        if(!in_array($formationId, $allFormationsId)){
            throw new Exception('Cette formation n\'existe pas.');
            }
        
        // la formation
        $formation = $this->formationManager->getFormationById($formationId);
        // les sections de la formation
        $allSections = $this->sectionManager->getSectionsByFormation($formationId);

        // Les lessons de la formation
        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons de la formation
        foreach($allLessons as $lesson){
            $lessonsId[] = $lesson->getId();
        }
        $firstLessonId = $lessonsId[0];
        $lastLessonId = end($lessonsId);

        // Si l'identifiant de la leçon demandé dans l'URL ne fait pas partie des identifiants de leçon de la formation
        if(!in_array($lessonId, $lessonsId)){
            throw new Exception('Cette leçon n\'existe pas');
        }

        // la leçon principale
        $mainLesson = $this->lessonManager->getLessonById($lessonId);
        // la section principale
        $sectionId = $mainLesson->getSectionId();
        
        $mainSection = $this->sectionManager->getSectionById($sectionId);

        // Le menu de la formation
        $menuFormation = [];
        foreach($allSections as $section){

            // Elements du menu formation
            $tableMenu['formationId'] = $formationId;
            $tableMenu['sectionTitle'] = $section->getTitle();
            $tableMenu['sectionPosition'] = $section->getPosition();
            $tableMenu['lessons'] =  $this->lessonManager->getLessonsBySection($section->getId());
            array_push($menuFormation, $tableMenu);  
        }

        // Elements de l'espace leçon
        $lessonContent['sectionTitle'] = $mainSection->getTitle();
        $lessonContent['lessonId'] = $mainLesson->getId();
        $lessonContent['lessonTitle'] = $mainLesson->getTitle();
        $lessonContent['lessonvideo'] = $this->videoYoutubeEmbed($mainLesson->getvideo());
        $lessonContent['lessonContent'] = $mainLesson->getContent();

        require_once(ROOT.'/views/admin/admin-formation-details.view.php');
    }


    // Espace student
    // student : page accueil
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
            $table1['id'] = $formation->getId();
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
                $table2['id'] = $formation->getId();
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
                $table3['id'] = $formation->getId();
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

    // student : page détail formation - première leçon
    public function studentFormationPage($studentId, $formationId){
        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();
        $this->resourceManager->loadResources();
        $this->formationByStudentManager->loadformationsByStudent($studentId);

        //Si une formation n'existe pas, page d'erreur
        $allFormations = $this->formationManager->getFormationsOnline();
        foreach($allFormations as $formation){
            $allFormationsId[] = $formation->getId();
        }

        if(!in_array($formationId, $allFormationsId)){
            throw new Exception('Cette formation n\'existe pas.');
            }        

        // la formation
        $formation = $this->formationManager->getFormationById($formationId);
        // les sections de la formation
        $allSections = $this->sectionManager->getSectionsByFormation($formationId);

        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons pour les boutons "précédent" et "suivant".
        foreach($allLessons as $lesson){
            $lessonsId[] = $lesson->getId();
        }
        $firstLessonId = $lessonsId[0];
        $lastLessonId = end($lessonsId);

        // Au clic du bouton accéder, passe la formation non suivi en suivi
        $formationsByStudentNotStarted = $this->formationByStudentManager->getFormationsByStudentNotStarted();
        if(isset($formationsByStudentNotStarted)){
            foreach($formationsByStudentNotStarted as $formationNotStarted){
                $formationByStudentNotStartedTable[] = $formationNotStarted->getFormationId();
            }
        }
        
        if(isset($formationsByStudentNotStarted) && in_array($formationId, $formationByStudentNotStartedTable)){
            $this->formationByStudentManager->updateFormationByStudentStatus($studentId, $formationId);
        }

        // Le menu de la formation, la première section et la première leçon de la première section
        $menuFormation = [];
        foreach($allSections as $section){
            // titre de la première section
            if($section->getPosition() === 1){
                $firstSectionId = $section->getId();
                $firstSectionTitle = $section->getTitle();
            }
            // la première leçon
            $lessonsFirstSection = $this->lessonManager->getLessonsBySection($firstSectionId);
            foreach($lessonsFirstSection as $lesson){
                if($lesson->getPosition() === 1){
                    $firstLesson = $lesson;
                }
            }
        
            // Elements du menu formation
            $tableMenu['formationId'] = $formationId;
            $tableMenu['sectionTitle'] = $section->getTitle();
            $tableMenu['sectionPosition'] = $section->getPosition();
            $tableMenu['lessons'] = $this->lessonManager->getLessonsBySection($section->getId());
            array_push($menuFormation, $tableMenu);  
        }

        // Elements de l'espace leçon
        $lessonContent['sectionTitle'] = $firstSectionTitle;
        $lessonContent['lessonId'] = $firstLesson->getId();
        $lessonContent['lessonTitle'] = $firstLesson->getTitle();
        $lessonContent['lessonvideo'] = $this->videoYoutubeEmbed($firstLesson->getvideo());
        $lessonContent['lessonContent'] = $firstLesson->getContent();

        // Le statut de la leçon pour l'étudiant
        $lessonStatus = $this->lessonByStudentManager->getLessonByStudentStatus($studentId, $lessonContent['lessonId']);


        require_once(ROOT.'/views\student\student-formation.view.php');
    }


    // student : page détail formation - n'importe quelle leçon
    public function studentLessonFormationPage($studentId, $formationId, $lessonId){

        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();
        $this->resourceManager->loadResources();
        $this->formationByStudentManager->loadformationsByStudent($studentId);

        //Si une formation n'existe pas, page d'erreur
        $allFormations = $this->formationManager->getFormationsOnline();
        foreach($allFormations as $formation){
            $allFormationsId[] = $formation->getId();
        }

        if(!in_array($formationId, $allFormationsId)){
            throw new Exception('Cette formation n\'existe pas.');
            }        

        // la formation
        $formation = $this->formationManager->getFormationById($formationId);
        // les sections de la formation
        $allSections = $this->sectionManager->getSectionsByFormation($formationId);


        // Les lessons de la formation
        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons de la formation
        foreach($allLessons as $lesson){
            $lessonsId[] = $lesson->getId();
        }
        $firstLessonId = $lessonsId[0];
        $lastLessonId = end($lessonsId);

        // Si l'identifiant de la leçon demandé dans l'URL ne fait pas partie des identifiants de leçon de la formation
        if(!in_array($lessonId, $lessonsId)){
            throw new Exception('Cette leçon n\'existe pas');
        }

        // la leçon principale
        $mainLesson = $this->lessonManager->getLessonById($lessonId);
        // la section principale
        $sectionId = $mainLesson->getSectionId();
        
        $mainSection = $this->sectionManager->getSectionById($sectionId);

        // Le menu de la formation
        $menuFormation = [];
        foreach($allSections as $section){

            // Elements du menu formation
            $tableMenu['formationId'] = $formationId;
            $tableMenu['sectionTitle'] = $section->getTitle();
            $tableMenu['sectionPosition'] = $section->getPosition();
            $tableMenu['lessons'] =  $this->lessonManager->getLessonsBySection($section->getId());
            array_push($menuFormation, $tableMenu);  
        }

        // Elements de l'espace leçon
        $lessonContent['sectionTitle'] = $mainSection->getTitle();
        $lessonContent['lessonId'] = $mainLesson->getId();
        $lessonContent['lessonTitle'] = $mainLesson->getTitle();
        $lessonContent['lessonvideo'] = $this->videoYoutubeEmbed($mainLesson->getvideo());
        $lessonContent['lessonContent'] = $mainLesson->getContent();

        // Le statut de la leçon pour l'étudiant
        $lessonStatus = $this->lessonByStudentManager->getLessonByStudentStatus($studentId, $lessonContent['lessonId']);
        
        require_once(ROOT.'/views/student/student-formation.view.php');
    }



    // Espace teacher
    // page accueil espace teacher
    public function setTeacherEspace($teacherId){
        $this->formationManager->loadFormations();
        
        $formationsOnline = $this->formationManager->getFormationsOnlineByTeacherId($teacherId);
        
        $formationsNotOnline = $this->formationManager->getformationsNotOnlineByTeacherId($teacherId);
       
        require_once(ROOT.'/views/teacher/teacher-espace.view.php');
    }

    // met en ligne une formation
    public function updateFormationOnline($formationId){
        $creationDate =  date("Y-m-d"); 

        if($this->formationManager->UpdateFormationOnline($formationId, $creationDate) === true){
            $_SESSION['alert'] = [
                "type" => "success",
                "msg" => "Votre formation est en ligne."         
                ];
        } else {
            $_SESSION['alert'] = [
                "type" => "danger",
                "msg" => "Votre formation n'a pas put être mise en ligne, veuillez réessayer."       
            ];
        }
    
            header('Location: '. URL . "teacherEspace");
    }

    // teacher : page formation - première leçon
    public function teacherFormationPage($teacherId, $formationId){
        
        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();
        $this->resourceManager->loadResources();

        //Si une formation n'existe pas, page d'erreur
        $allFormations = $this->formationManager->getFormations();
        foreach($allFormations as $formation){
            $allFormationsId[] = $formation->getId();
        }

        if(!in_array($formationId, $allFormationsId)){
            throw new Exception('Cette formation n\'existe pas.');
            }

        // la formation
        $formation = $this->formationManager->getFormationById($formationId);
        // les sections de la formation

        // si le professeur essaie d'accéder à une formation qui ne lui appartient pas.
        if($teacherId !== $formation->getTeacherId()){
            throw new EXception('Vous ne pouvez pas accéder à cette page');
        }

        $allSections = $this->sectionManager->getSectionsByFormation($formationId);

        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons pour les boutons "leçon précédente" et leçon "suivante".
        foreach($allLessons as $lesson){
            $lessonsId[] = $lesson->getId();
        }
        $firstLessonId = $lessonsId[0];
        $lastLessonId = end($lessonsId);


        // Le menu de la formation, la première section et la première leçon de la première section
        $menuFormation = [];
        foreach($allSections as $section){
            // titre de la première section
            if($section->getPosition() === 1){
                $firstSectionId = $section->getId();
                $firstSectionTitle = $section->getTitle();
            }
            // la première leçon
            $lessonsFirstSection = $this->lessonManager->getLessonsBySection($firstSectionId);
            foreach($lessonsFirstSection as $lesson){
                if($lesson->getPosition() === 1){
                    $firstLesson = $lesson;
                }
            }
        
            // Elements du menu formation
            $tableMenu['formationId'] = $formationId;
            $tableMenu['sectionTitle'] = $section->getTitle();
            $tableMenu['sectionPosition'] = $section->getPosition();
            $tableMenu['lessons'] = $this->lessonManager->getLessonsBySection($section->getId());
            array_push($menuFormation, $tableMenu);  
        }

        // Elements de l'espace leçon
        $lessonContent['sectionTitle'] = $firstSectionTitle;
        $lessonContent['lessonId'] = $firstLesson->getId();
        $lessonContent['lessonTitle'] = $firstLesson->getTitle();
        $lessonContent['lessonvideo'] = $this->videoYoutubeEmbed($firstLesson->getvideo());
        $lessonContent['lessonContent'] = $firstLesson->getContent();

       
        require_once(ROOT.'/views/teacher/teacher-formation-details.view.php');
    }


        // teacher : page détail formation - n'importe quelle leçon
    public function teacherLessonFormationPage($teacherId, $formationId, $lessonId){
        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();
        $this->resourceManager->loadResources();

        //Si une formation n'existe pas, page d'erreur
        $allFormations = $this->formationManager->getFormationsOnline();
        foreach($allFormations as $formation){
            $allFormationsId[] = $formation->getId();
        }

        if(!in_array($formationId, $allFormationsId)){
            throw new Exception('Cette formation n\'existe pas.');
            }

        // la formation
        $formation = $this->formationManager->getFormationById($formationId);
        // les sections de la formation

        // si le professeur essaie d'accéder à une formation qui ne lui appartient pas.
        if($teacherId !== $formation->getTeacherId()){
            throw new EXception('Vous ne pouvez pas accéder à cette page');
        }

        $allSections = $this->sectionManager->getSectionsByFormation($formationId);
        // Les lessons de la formation
        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons de la formation
        foreach($allLessons as $lesson){
            $lessonsId[] = $lesson->getId();
        }
        $firstLessonId = $lessonsId[0];
        $lastLessonId = end($lessonsId);

        // Si l'identifiant de la leçon demandé dans l'URL ne fait pas partie des identifiants de leçon de la formation
        if(!in_array($lessonId, $lessonsId)){
            throw new Exception('Cette leçon n\'existe pas');
        }

        // la leçon principale
        $mainLesson = $this->lessonManager->getLessonById($lessonId);
        // la section principale
        $sectionId = $mainLesson->getSectionId();
        
        $mainSection = $this->sectionManager->getSectionById($sectionId);

        // Le menu de la formation
        $menuFormation = [];
        foreach($allSections as $section){

            // Elements du menu formation
            $tableMenu['formationId'] = $formationId;
            $tableMenu['sectionTitle'] = $section->getTitle();
            $tableMenu['sectionPosition'] = $section->getPosition();
            $tableMenu['lessons'] =  $this->lessonManager->getLessonsBySection($section->getId());
            array_push($menuFormation, $tableMenu);  
        }

        // Elements de l'espace leçon
        $lessonContent['sectionTitle'] = $mainSection->getTitle();
        $lessonContent['lessonId'] = $mainLesson->getId();
        $lessonContent['lessonTitle'] = $mainLesson->getTitle();
        $lessonContent['lessonvideo'] = $this->videoYoutubeEmbed($mainLesson->getvideo());
        $lessonContent['lessonContent'] = $mainLesson->getContent();
        
        require_once(ROOT.'/views/teacher/teacher-formation-details.view.php');
    }

    // teacher - créer une formation

    public function createFormation(){

        require_once(ROOT.'/views/teacher/formation-add.view.php');
    }

    public function createFormationStep($stepNumber){
        
        // en fonction du numéro d'étape (1 pour la section 1, 2 pour la section 2...), génére une page de création de section mais pour quelle formation? passer en session? En url?
        // suppose que l'utilisateur a rentré ses informations, a valider le formulaire, les données ont été validées en js et php et rentré en bdd, puis les informations des sections sont apellés de la bdd.
        // peux-t-il revenir en arrière pour ajouter ou supprimer des sections? il faudrait oui.

        // en modifiant, peux-t-il supprimer des sections? en ajouter? oui il faudrait

        require_once(ROOT.'/views/teacher/formation-add-step.view.php');
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
                $table['id'] = $formation->getId();
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
            $table['id'] = $formation->getId();
            $table['title'] = $formation-> getTitle();
            $table['picture'] = $formation-> getPicture();
            $table['description'] = $formation-> getDescription();
            $table['firstname'] = $teacher->getFirstname();
            $table['lastname'] = $teacher->getLastname();
            array_push($formationsTable, $table);
        }
        return $formationsTable;
    }
    
    public function ajaxUpdateLessonAndFormationStatus($studentId, $lessonId, $formationId, $status, ){
        // met à jour le statut de la leçon
        $this->lessonByStudentManager->updateLessonByStudentStatus($studentId, $lessonId, $status);

        // récupére le nombre de lessons finie pour une formation et le nombre de lesson total
        $lessonsTable = $this->lessonByStudentManager->getNbrStatusLessonByStudent($studentId, $formationId);

        // calcul le pourcentage de progression de la formation
        $formationProgression = round(($lessonsTable['finishedLessonNbr'] * 100)/$lessonsTable['totalLessonNbr']);

        // met à jour la progression de la formation
        $this->formationByStudentManager->updateFormationByStudentProgression($studentId, $formationId, $formationProgression);

    }    
}


