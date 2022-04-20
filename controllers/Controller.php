<?php

require_once(ROOT.'/models/managers/AdminManager.class.php');
require_once(ROOT.'/models/managers/StudentManager.class.php');
require_once(ROOT.'/models/managers/TeacherManager.class.php');
require_once(ROOT.'/models/managers/FormationManager.class.php');
require_once(ROOT.'/models/managers/SectionManager.class.php');
require_once(ROOT.'/models/managers/LessonManager.class.php');
require_once(ROOT.'/models/managers/FormationByStudentManager.class.php');
require_once(ROOT.'/models/managers/LessonByStudentManager.class.php');

class Controller{
    private $adminManager;
    private $studentManager;
    private $teacherManager;
    private $formationManager;
    private $sectionManager;
    private $lessonManager;
    private $formationByStudentManager;
    private $lessonByStudentManager;

    public function __construct(){
        $this->adminManager = new AdminManager();
        $this->studentManager = new StudentManager();
        $this->teacherManager = new TeacherManager();
        $this->formationManager = new FormationManager();
        $this->sectionManager = new SectionManager();
        $this->lessonManager = new LessonManager();
        $this->formationByStudentManager = new FormationByStudentManager;
        $this->lessonByStudentManager = new LessonByStudentManager;
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
                    $alert = "mot de passe non valide";
                }
            } else {
                $alert = "mot de passe ou mail non valide";
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
                        // ajout utilisateur en bdd
                        $this->studentManager->addStudentInBdd($pseudo, $mail, $password);
                            // recharge les étudiants
                            $this->studentManager->loadStudents();
                            // récupére l'étudiant ajouté
                            $student = $this->studentManager->getStudentByMail($mail);
                            $studentPseudo = $student->getPseudo();
                            $studentId = $student->getId();

                            // ajout formations en ligne à l'étudiant
                            $this->formationManager->loadFormations();
                            $formationsOnlineId = $this->formationManager->getFormationsOnlineId();
                            $this->formationByStudentManager->addStudentByFormationOnline($formationsOnlineId, $studentId);

                            // ajout leçons des formations en lignes à l'étudiant
                            $this->lessonManager->loadLessons();

                            $allFormationOnlineTable = [];
                            foreach($formationsOnlineId as $formationId){
                                $tableFormation['formationId'] = $formationId;
                                $tableFormation['lessonId'] = $this->lessonManager->getLessonsIdByFormation($formationId);
                                array_push($allFormationOnlineTable, $tableFormation);
                            }

                            $this->lessonByStudentManager->addStudentToLessons($allFormationOnlineTable, $studentId);

                            $_SESSION['access'] = 'student';
                            $_SESSION['id'] = $studentId;
                            $_SESSION['ps'] = $studentPseudo;
                            genereCookieSession();
                            header('Location: '. URL .'studentEspace');

                         /*else {
                            throw new Exception('Erreur dans votre inscription, veuillez recommencer');
                        } */
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
    public function ajoutImageFile($image, $text, $dir){
        $random = rand(0,9999);
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageFile = $dir."_".$random.$text.".".$extension;
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
                                    if(($pictureProfileURL = ajoutImageFile($pictureProfile, $lastname, $dir)) !== false){

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

            $array = explode("&", $videoYT);
        }
        return $array[0];
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
        $teacherId = $_SESSION['id'];
        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();

        $formationsIdPossible = $this->formationManager->getformationsNotOnlineIdByTeacherId($teacherId);
        
        // vérifie que toutes les sections de la formations ont des leçons
        $allSections = $this->sectionManager->getSectionsByFormation($formationId);
        $sectionsLessons = true;
        foreach($allSections as $section){
            if($this->lessonManager->getLessonsBySection($section->getId()) === null){
                $sectionsLessons = false;
            }
        }

        // si la formation n'appartient pas au formateur ou qu'elle est en ligne
        if(!in_array($formationId, $formationsIdPossible)){
            throw new Exception('vous ne pouvez pas mettre en ligne cette formation');
            // si la formation n'a pas de sections
        } else if($sectionsLessons === false){
            throw new Exception('Vous ne pouvez pas mettre en ligne une formation où il manque des leçons.');
        } else {
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

        // ajout de la formation à tous les étudiants
        $this->studentManager->loadStudents();
        $studentsId = $this->studentManager->getStudentsId();
        $this->formationByStudentManager->addFormationToStudent($formationId, $studentsId);
        
        // ajout des lesons de la formations à tous les étudiants
        $lessonsId = $this->lessonManager->getLessonsIdByFormation($formationId);
        $this->lessonByStudentManager->addLessonsToStudent($lessonsId, $formationId, $studentsId);

        header('Location: '. URL . "teacherEspace");

        }
    }

    // teacher : page formation - première leçon
    public function teacherFormationPage($teacherId, $formationId){
        
        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();

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

        foreach($allSections as $section){
            if($this->lessonManager->getLessonsBySection($section->getId()) === null){
                throw new Exception('cette formation manque de leçon');
            }
        }

        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons pour les boutons "leçon précédente" et leçon "suivante".
        if(isset($allLessons)){
            foreach($allLessons as $lesson){
            $lessonsId[] = $lesson->getId();
            }
        } else {
            throw new Exception('cette formation manque de leçon');
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
       

        // si le professeur essaie d'accéder à une formation qui ne lui appartient pas.
        if($teacherId !== $formation->getTeacherId()){
            throw new EXception('Vous ne pouvez pas accéder à cette page');
        }

        // les sections de la formation
        $allSections = $this->sectionManager->getSectionsByFormation($formationId);
        
        foreach($allSections as $section){
            if($this->lessonManager->getLessonsBySection($section->getId()) === null){
                throw new Exception('cette formation manque de leçon');
            }
        }
        
        // Les lessons de la formation
        $allLessons = $this->lessonManager->getLessonsByFormation($formationId);
        // les identifiants des leçons de la formation

        if(isset($allLessons)){
            foreach($allLessons as $lesson){
                $lessonsId[] = $lesson->getId();
            }
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
        $errorTitle = '';
        $errorDescription = '';
        $errorPicture = '';
        $errorSection = '';
        $dataStatus = [];

        // vérification titre formation
        if(isset($_POST['formationTitle']) && !empty($_POST['formationTitle'])){
            $formationTitle = secureData($_POST['formationTitle']);
            if(verifyFormationTitle($formationTitle) === true){
                $dataStatus['formationTitle'] = true;
            } else {
                $error = 'Erreur : titre formation';
                $errorTitle = verifyFormationTitle($formationTitle);
                $dataStatus['formationTitle'] = false;
            }
        }

        // vérification description formation
        if(isset($dataStatus['formationTitle']) && $dataStatus['formationTitle'] === true){
            if(isset($_POST['formationDescription']) && !empty($_POST['formationDescription'])){
                $description = secureData($_POST['formationDescription']);
                if(verifyDescription($description) === true){
                    $dataStatus['description'] = true;
                } else {
                    $error = 'Erreur : description';
                    $errorDescription = verifyDescription($description);
                    $dataStatus['description'] = false;
                }
            }

        }
       

        // vérification image formation
        if(isset($dataStatus['description']) && $dataStatus['description'] === true){
            if(isset($_FILES['formationPicture']) && !empty($_FILES['formationPicture'])){
                $formationPicture = $_FILES['formationPicture'];
                if(verifyPicture($formationPicture) === true){
                    $dataStatus['formationPicture'] = true;
                } else {
                    $error = 'Erreur : image';
                    $errorPicture = verifyPIcture($formationPicture);
                    $dataStatus['formationPicture'] = false;
                }
            } 
        }
        

        // vérification titre des sections
        if(isset($dataStatus['formationPicture']) && $dataStatus['formationPicture'] === true){
            if(isset($_POST['sectionTitle']) && !empty($_POST['sectionTitle'])){
                foreach($_POST['sectionTitle'] as $sectionTitle){
                    $sectionsTitle[] = secureData($sectionTitle);
                }
                $dataStatus['sectionTitle'] = [];
                
                foreach($sectionsTitle as $title){

                    if(verifyTitleSection($title) === true){
                        array_push($dataStatus['sectionTitle'], true);

                    } else if(verifyTitleSection($title) !== true) {
                        $error = 'Erreur : titre section';
                        $errorSection = 'Erreur avec un titre, lettres autorisées seulement';
                        array_push($dataStatus['sectionTitle'], false);

                        ob_start();
                        for($i= 1; $i< count($sectionsTitle); $i++){ ?>

                        <div id="containerSection<?= $i + 1 ?>">
                            <p id="errorSectionTitle<?= $i + 1 ?>" class="mb-3 error-msg"></p>
                            <label for="sectionTitle<?= $i + 1 ?>" class="form-label labelSection">Section <?= $i + 1 ?> - titre :</label>
                            <input type="hidden" value="<?= $i + 1 ?>" name="sectionOrder[]" class="inputOrderSection">
                            <input type="text" id="sectionTitle<?= $i + 1 ?>" class="form-control sectionTitleClass" name="sectionTitle[]" value="<?= $_POST['sectionTitle'][$i] ?? '' ?>" minlength="2" maxlength="70" required>
                            <label for="nbrLesson<?= $i + 1 ?>" class="my-2">Nombre de lesson :</label>
                            <label for="nbrLesson1" class="my-2">Nombre de lesson :</label>
                        <select name="nbrLesson[]" id="nbrLesson<?= $i + 1 ?>" class="nbrLesson" required>
                            <option value="" ></option>
                            <?php for($j = 1; $j<=10; $j++){ ?>
                            <option value="<?= $j ?>"
                            <?php if(isset($_POST['nbrLesson'][0])){
                                    if($_POST['nbrLesson'][0] === $j){
                                        echo "selected";
                                    }
                                } ?>><?= $i ?>
                                </option>
                            <?php } ?>
                            </select>
                        </div>
                        <?php }   
                        $contentSectionTitle = ob_get_clean(); 
                    }     
                }
            }
        }

        // vérifie que tous les nombres de leçons sont renseignés
        // vérification titre des sections
        if(isset($dataStatus['sectionTitle'])){
            if(!in_array(false, $dataStatus['sectionTitle'])){
                if(isset($_POST['nbrLesson'])){
                    $nbrLesson = $_POST['nbrLesson'];
                    if(count($sectionsTitle) === count($_POST['nbrLesson'])){
                        $nbrLessonStatus = true;
                        foreach($_POST['sectionOrder'] as $order){
                            $sectionOrder[] = $order;
                        }

                    } else {
                        $nbrLessonStatus = false;
                        $error = 'Erreur : Section - nombre de leçon';
                        $errorSection = 'Vous n\'avez pas renseigné  tous les nombres de leçons';
                    }
                }
            }
        }


        if(isset($nbrLessonStatus) && $nbrLessonStatus === true){
                // ajout image en dossier
                $form = 'form';
                $dir = 'public/images/formation/';
                if(($pictureFormationURL = ajoutImageFile($formationPicture, $form, $dir)) !== false){
                
                    // ajout formation en bdd
                    $this->formationManager->addFormationInBdd($formationTitle, $description, $pictureFormationURL, $_SESSION['id']);
                    $this->formationManager->loadFormations();

                    // ajout sections en bdd
                    //1. je récupére l'identifiant de la formation qui vient d'être ajouté

                    $lastFormationId = $this->formationManager->getLastFormationIdByTeacher($_SESSION['id']);

                    $table = [];
                    $sectionsTable = [];
                    for($i=0; $i<count($sectionOrder); $i++){
                        $table['title'] = $sectionsTitle[$i];
                        $table['position'] = $sectionOrder[$i];
                        $table['nbrLesson'] = $nbrLesson[$i];
                        $table['formationId'] = $lastFormationId;
                        array_push($sectionsTable, $table);
                    }

                    $this->sectionManager->addSectionInBdd($sectionsTable);

                    // récupére les identifiants des sections
                    $this->sectionManager->loadSections();
                    $sectionsId = $this->sectionManager->getSectionsIdByFormation($lastFormationId);

                    // on récupére les données à placer en variable $_SESSION
                    $tableSection = [];
                    $table = [];
                        for($i = 0; $i < count($sectionsTitle); $i++){
                            $table['id'] = $sectionsId[$i];
                            $table['title'] = $sectionsTitle[$i];
                            $table['nbrLesson'] = $nbrLesson[$i];
                            array_push($tableSection, $table);
                        }

                    // en variable session ce dont j'ai besoin pour la suite
                    $_SESSION['sections'] = $tableSection;
                    $_SESSION['formationId'] = $lastFormationId;
                    $_SESSION['nbrSections'] =  count($_SESSION['sections']);
                    $_SESSION['step'] = 1;

                    header("Location: ". URL . "teacherEspace/createFormation/step/1");
                } else {
                    throw new Exception('Il y a une erreur, veuillez réessayer.');
                }
        }
        require_once(ROOT.'/views/teacher/formation-add.view.php');
    }

    // je crée les leçons des sections
    public function createFormationStep(int $step){
        $countSection = count($_SESSION['sections']);
        $nextStep = $step + 1;
        $sectionId = $_SESSION['sections'][$step-1]['id'];
        $sectionTitle = $_SESSION['sections'][$step-1]['title'];
        $numberLesson = $_SESSION['sections'][$step-1]['nbrLesson'];

        if($countSection < $step){
            header("Location: ". URL . "teacherEspace/createFormation/step/1");
        }

        $error = '';
        $errorTitleLesson = [];
        $errorVideoLesson = [];
        $errorContentLesson = [];
        $dataStatus = [];

        // vérification titres leçons
        if(isset($_POST['lessonTitle']) && !empty($_POST['lessonTitle'])){
            foreach($_POST['lessonTitle'] as $title){
                $lessonsTitle[] = secureData($title);
            }
            $dataStatus['lessonTitle'] = [];
            for($i = 0; $i < count($lessonsTitle); $i++){
                if(verifyTitleLesson($lessonsTitle[$i]) === true){
                    array_push($dataStatus['lessonTitle'], true);
                } else {
                    $error = 'Erreur : titre de section';
                    $errorTitleLesson[$i] = 'Erreur dans le titre';
                    array_push($dataStatus['lessonTitle'], false);
                }
            }
        }

        // vérification Video youtube
        if(isset($dataStatus['lessonTitle'])){
            if(!in_array(false, $dataStatus['lessonTitle'])){
                if(isset($_POST['lessonContent']) && !empty($_POST['lessonVideo'])){
                    foreach($_POST['lessonVideo'] as $video){
                        $lessonsVideo[] = secureData($video);
                    }
                    $dataStatus['lessonVideo'] = [];
                    for($i = 0; $i < count($lessonsVideo); $i++){
                        if(verifyLessonVideo($lessonsVideo[$i]) === true){
                            array_push($dataStatus['lessonVideo'], true);
                        } else {
                            $error = 'Erreur : vidéo youtube';
                            $errorVideoLesson[$i] = 'Erreur avec la video';
                            array_push($dataStatus['lessonVideo'], false);
                        }
                    }
                }
            }
        }

        // vérification contenu leçon
        if(isset($dataStatus['lessonVideo'])){
            if(!in_array(false, $dataStatus['lessonVideo'])){
                if(isset($_POST['lessonContent']) && !empty($_POST['lessonContent'])){
                    foreach($_POST['lessonContent'] as $content){
                        $lessonsContent[] = secureData($content);
                    }
                    $dataStatus['lessonContent'] = [];
                    for($i = 0; $i < count($lessonsContent); $i++){
                        if(verifyLessonContent($lessonsContent[$i]) === true){
                            array_push($dataStatus['lessonContent'], true);
                        } else {
                            $error = 'Erreur : contenu de la leçon';
                            $errorContentLesson[$i] = 'Erreur avec le contenu de la leçon';
                            array_push($dataStatus['lessonContent'], false);
                        }
                    }
                }
            }
        }

        if(isset($dataStatus['lessonContent'])){
            if(!in_array(false, $dataStatus['lessonContent'])){

                //1. je crée le tableau final
                $table = [];
                $lessons = [];
                for($i=0; $i<$numberLesson; $i++){
                    $table['title'] = $lessonsTitle[$i];
                    $table['content'] = $lessonsContent[$i];
                    $table['video'] = $lessonsVideo[$i];
                    $table['position'] = $_POST['lessonOrder'][$i];
                    $table['formationId'] = $_SESSION['formationId'];
                    $table['sectionId'] = $sectionId;
                array_push($lessons, $table);
                }

                //2. je boucle sur le tableau et insére les leçons
                foreach($lessons as $lesson){
                    $this->lessonManager->addLessonInBdd($lesson);
                }
                
                 //3. je modifie la variable session step qui passe à + 1
                $_SESSION['step'] = $nextStep;

                 //4. On redirige vers la bonne page
                if($countSection > $step){
                    header("Location: ". URL . "teacherEspace/createFormation/step/".$nextStep);
                } else if($countSection === $step){
                    // 5. je vide la variable $_SESSION des informations lié à la formation
                    unset($_SESSION['sections']);
                    unset($_SESSION['formationId']);
                    unset($_SESSION['nbrSections']);
                    unset($_SESSION['step']);

                    header("location: ". URL . "teacherEspace");
                }
            }
        }
    
        require_once(ROOT.'/views/teacher/formation-add-step.view.php');
    }
    

    // panneau de modification, possibilité d'ajouter des sections
    public function modifyFormation($formationId){
        // si cette formation n'appartient pas au formateur ou est en ligne, erreur
        $teacherId = $_SESSION['id'];
        $this->formationManager->loadFormations();
        $formationsIdPossible = $this->formationManager->getformationsNotOnlineIdByTeacherId($teacherId);
        if(!in_array($formationId, $formationsIdPossible)){
            throw new Exception('Vous ne pouvez pas modifier cette formation, elle ne vous appartient pas où elle est déjà en ligne.');
        } else {

            // je dois récupérer tous les éléments de la formation
            $this->formationManager->loadFormations();
            $this->sectionManager->loadSections();
            $this->lessonManager->loadLessons();

    
            // la formation
            $formation = $this->formationManager->getFormationById($formationId);
            
            // les sections de la formation
            $sections = $this->sectionManager->getSectionsByFormation($formationId);

            $existingSectionElements = [];
            $tableElementSection = [];
                for($i = 0; $i < count($sections); $i++){
                    $tableElementSection['id'] = $sections[$i]->getId();
                    $tableElementSection['title'] = $sections[$i]->getTitle();
                    $tableElementSection['position'] = $sections[$i]->getPosition();
                    if($this->lessonManager->getLessonsBySection($sections[$i]->getId()) !== null){
                        $nbrLesson = count($this->lessonManager->getLessonsBySection($sections[$i]->getId()));
                        $tableElementSection['nbrLesson'] = $nbrLesson;
                        $tableElementSection['nbrLessonCreated'] = $nbrLesson;
                    } else {
                        $tableElementSection['nbrLesson'] = $sections[$i]->getLessonNumber();
                        $tableElementSection['nbrLessonCreated'] = 0;
                    }
                    array_push($existingSectionElements, $tableElementSection);
                }

            $errorSection = '';
            $dataStatus = [];
            // vérification titre des sections
            if(isset($_POST['sectionTitle']) && !empty($_POST['sectionTitle'])){
                foreach($_POST['sectionTitle'] as $sectionTitle){
                    $sectionsTitle[] = secureData($sectionTitle);
                }
                $dataStatus['sectionTitle'] = [];
                
                foreach($sectionsTitle as $title){

                    if(verifyTitleSection($title) === true){
                        array_push($dataStatus['sectionTitle'], true);

                    } else if(verifyTitleSection($title) !== true) {
                        $error = 'Erreur : titre section';
                        $errorSection = 'Erreur avec un titre, lettres autorisées seulement';
                        array_push($dataStatus['sectionTitle'], false);

                        //sections existante + nouvelles créés
                        $nbrSections = count($sections) + count($sectionsTitle);

                        ob_start();
                        for($i= 1; $i< $nbrSections; $i++){ ?>

                        <div id="containerSection<?= $i + 1 ?>">
                            <p id="errorSectionTitle<?= $i + 1 ?>" class="mb-3 error-msg"></p>
                            <label for="sectionTitle<?= $i + 1 ?>" class="form-label labelSection">Section <?= $i + 1 ?> - titre :</label>
                            <input type="hidden" value="<?= $i + 1 ?>" name="sectionOrder[]" class="inputOrderSection">
                            <input type="text" id="sectionTitle<?= $i + 1 ?>" class="form-control sectionTitleClass" name="sectionTitle[]" value="<?= $_POST['sectionTitle'][$i] ?? '' ?>" minlength="2" maxlength="70" required>
                            <label for="nbrLesson<?= $i + 1 ?>" class="my-2">Nombre de lesson :</label>
                            <label for="nbrLesson1" class="my-2">Nombre de lesson :</label>
                        <select name="nbrLesson[]" id="nbrLesson<?= $i + 1 ?>" class="nbrLesson" required>
                            <option value="" ></option>
                            <?php for($j = 1; $j<=10; $j++){ ?>
                            <option value="<?= $j ?>"
                            <?php if(isset($_POST['nbrLesson'][0])){
                                    if($_POST['nbrLesson'][0] === $j){
                                        echo "selected";
                                    }
                                } ?>><?= $i ?>
                                </option>
                            <?php } ?>
                            </select>
                        </div>
                        <?php }   
                        $contentSectionTitle = ob_get_clean(); 
                    }     
                }
            }
        }

        // vérifie que tous les nombres de leçons sont renseignés
        if(isset($dataStatus['sectionTitle'])){
            if(!in_array(false, $dataStatus['sectionTitle'])){
                if(isset($_POST['nbrLesson'])){
                    $nbrLesson = $_POST['nbrLesson'];
                    if(count($sectionsTitle) === count($_POST['nbrLesson'])){
                        $nbrLessonStatus = true;

                        foreach($_POST['sectionOrder'] as $order){
                            $sectionOrder[] = $order;
                        }

                    } else {
                        $nbrLessonStatus = false;
                        $error = 'Erreur : Section - nombre de leçon';
                        $errorSection = 'Vous n\'avez pas renseigné  tous les nombres de leçons';
                    }
                }
            }
        }


        if(isset($nbrLessonStatus) && $nbrLessonStatus === true){
            //1. je crée le tableau final des sections

            $table = [];
            $sectionsTable = [];
            for($i=0; $i<count($sectionOrder); $i++){
                $table['title'] = $sectionsTitle[$i];
                $table['position'] = $sectionOrder[$i];
                $table['nbrLesson'] = $nbrLesson[$i];
                $table['formationId'] = $formationId;
                array_push($sectionsTable, $table);
            }

            // 2. J'ajoute les section en bdd
            $this->sectionManager->addSectionInBdd($sectionsTable);

            header("location: ". URL . "teacherEspace/modify/".$formationId);
        }

        require_once(ROOT.'/views/teacher/formation-modify.view.php');
    }

    // modifie les éléments généraux d'une formation
    public function modifyFormationGeneral($formationId){
        // si cette formation n'appartient pas au formateur ou est en ligne, erreur
        $teacherId = $_SESSION['id'];
        $this->formationManager->loadFormations();
        $formationsIdPossible = $this->formationManager->getformationsNotOnlineIdByTeacherId($teacherId);
        if(!in_array($formationId, $formationsIdPossible)){
            throw new Exception('vous ne pouvez pas modifier cette formation');
        } else {
            // je dois récupérer tous les éléments de la formation
            $this->formationManager->loadFormations();
            //$this->sectionManager->loadSections();
            //$this->lessonManager->loadLessons();
    
            // la formation
            $formation = $this->formationManager->getFormationById($formationId);

            // les sections
           // $sections = $this->sectionManager->getSectionsByFormation($formationId);

        /*    
            // on récupére les données à placer en variable $_SESSION
            $tableSection = [];
            $table = [];
                for($i = 0; $i < count($sections); $i++){
                    $table['id'] = $sections[$i]->getId();
                    $table['title'] = $sections[$i]->getTitle();
                    $table['position'] = $sections[$i]->getPosition();
                    $table['nbrLesson'] = count($this->lessonManager->getLessonsBySection($sections[$i]->getId()));
                    array_push($tableSection, $table);
                }

            // en variable session ce dont j'ai besoin pour la suite
            $_SESSION['sections'] = $tableSection;
            $_SESSION['nbrSections'] =  count($_SESSION['sections']);

        */
            
            $errorTitle = '';
            $errorDescription = '';
            $errorPicture = '';
        //    $errorSection = '';
            $dataStatus = [];

            // vérification titre formation
            if(isset($_POST['formationTitle']) && !empty($_POST['formationTitle']) && $_POST['formationTitle'] !== $formation->getTitle()){
                $title = secureData($_POST['formationTitle']);
                if(verifyFormationTitle($title) === true){
                    $dataStatus['title'] = true;
                } else {
                    $error = 'Erreur : titre formation';
                    $errorTitle = verifyFormationTitle($title);
                    $dataStatus['title'] = false;
                }
            } else {
                $dataStatus['title'] = true;
                $title = $formation->getTitle();
            }

            // vérification description formation
            if(isset($dataStatus['title']) && $dataStatus['title'] === true){
                if(isset($_POST['formationDescription']) && !empty($_POST['formationDescription']) && $_POST['formationDescription'] !== $formation->getDescription()){
                    $description = secureData($_POST['formationDescription']);
                    if(verifyDescription($description) === true){
                        $dataStatus['description'] = true;
                    } else {
                        $error = 'Erreur : description';
                        $errorDescription = verifyDescription($description);
                        $dataStatus['description'] = false;
                    }
                } else {
                    $dataStatus['description'] = true;
                    $description = $formation->getDescription();
                }
            }

            // vérification image formation
            if(isset($dataStatus['description']) && $dataStatus['description'] === true){
                if(isset($_FILES['formationPicture']) && $_FILES['formationPicture']['size'] > 0){
                    $formationPicture = $_FILES['formationPicture'];
                    if(verifyPicture($formationPicture) === true){
                        $dataStatus['picture'] = true;
                        unlink($formation->getPicture());
                        $form = 'formM';
                        $dir = 'public/images/formation/';
                        $picture = ajoutImageFile($formationPicture, $form, $dir);
                    } else {
                        $error = 'Erreur : image';
                        $errorPicture = verifyPIcture($formationPicture);
                        $dataStatus['picture'] = false;
                    }
                } else {
                    $dataStatus['picture'] = true;
                    $picture = $formation->getPicture();
                }
            }
        }

        if(isset($dataStatus['picture']) && $dataStatus['picture'] === true){
            if(isset($_POST['envoi']) && $_POST['envoi'] === 'envoi'){

                $this->formationManager->updateFormationInBdd($formationId, $title, $description, $picture);

            header("location: ". URL . "teacherEspace/modify/".$formationId);
            }
        }

        require_once(ROOT.'/views/teacher/formation-modify-general.view.php');
    }


    // modifier une section
    public function modifyFormationStep($formationId, $step){
        $this->formationManager->loadFormations();
        $this->sectionManager->loadSections();
        $this->lessonManager->loadLessons();

        // toutes les sections
        $allSections = $this->sectionManager->getSectionsByFormation($formationId);

        // nombre de section
        $countSection = count($allSections);
        
        // Liste des étapes possibles
        foreach($allSections as $section){
            $stepsPossible[] = $section->getPosition();
        }
        
        // Tableau des identifiants des formations que le formateur peut modifier
        $formationsIdPossible = $this->formationManager->getformationsNotOnlineIdByTeacherId($_SESSION['id']);
        
        // Si la formation n'appartient pas au formateur ou est déjà en ligne
        if(!in_array($formationId, $formationsIdPossible)){
            throw new Exception('vous ne pouvez pas modifier cette formation');
        } else if(!in_array($step, $stepsPossible)){
            throw new Exception('Cette étape n\'existe pas');
        } else {
            // la section actuelle
            foreach($allSections as $section){
                if($section->getPosition() === $step){
                    $theSection = $section;
                } 
            }
            // nombre de leçon de la section
            $numberLesson = $theSection->getLessonNumber();

            // identifiant de la section
            $sectionId = $theSection->getId();

            // les leçons de la section
            $allLessons = $this->lessonManager->getLessonsBySection($sectionId);

            $error = '';
            $errorTitleLesson = [];
            $errorVideoLesson = [];
            $errorContentLesson = [];
            $dataStatus = [];
    
            // vérification titres leçons
            if(isset($_POST['lessonTitle']) && !empty($_POST['lessonTitle'])){
                foreach($_POST['lessonTitle'] as $title){
                    $lessonsTitle[] = secureData($title);
                }
                $dataStatus['lessonTitle'] = [];
                for($i = 0; $i < count($lessonsTitle); $i++){
                    if(verifyTitleLesson($lessonsTitle[$i]) === true){
                        array_push($dataStatus['lessonTitle'], true);
                    } else {
                        $error = 'Erreur : titre de section';
                        $errorTitleLesson[$i] = 'Erreur dans le titre';
                        array_push($dataStatus['lessonTitle'], false);
                    }
                }
            }
    
            // vérification Video youtube
            if(isset($dataStatus['lessonTitle'])){
                if(!in_array(false, $dataStatus['lessonTitle'])){
                    if(isset($_POST['lessonVideo']) && !empty($_POST['lessonVideo'])){
                        foreach($_POST['lessonVideo'] as $video){
                            $lessonsVideo[] = secureData($video);
                        }
                        $dataStatus['lessonVideo'] = [];
                        for($i = 0; $i < count($lessonsVideo); $i++){
                            if(verifyLessonVideo($lessonsVideo[$i]) === true){
                                array_push($dataStatus['lessonVideo'], true);
                            } else {
                                $error = 'Erreur : vidéo youtube';
                                $errorVideoLesson[$i] = 'Erreur avec la video';
                                array_push($dataStatus['lessonVideo'], false);
                            }
                        }
                    }
                }
            }
    
            // vérification contenu leçon
            if(isset($dataStatus['lessonVideo'])){
                if(!in_array(false, $dataStatus['lessonVideo'])){
                    if(isset($_POST['lessonContent']) && !empty($_POST['lessonContent'])){
                        foreach($_POST['lessonContent'] as $content){
                            $lessonsContent[] = secureData($content);
                        }
                        $dataStatus['lessonContent'] = [];
                        for($i = 0; $i < count($lessonsContent); $i++){
                            if(verifyLessonContent($lessonsContent[$i]) === true){
                                array_push($dataStatus['lessonContent'], true);
                            } else {
                                $error = 'Erreur : contenu de la leçon';
                                $errorContentLesson[$i] = 'Erreur avec le contenu de la leçon';
                                array_push($dataStatus['lessonContent'], false);
                            }
                        }
                    }
                }
            }
    
            if(isset($dataStatus['lessonContent'])){
                if(!in_array(false, $dataStatus['lessonContent'])){
                    if(isset($_POST['envoi']) && $_POST['envoi'] === 'envoi'){
    
                        //1. je crée le tableau final
                        $table = [];
                        $lessons = [];
                        for($i=0; $i<$numberLesson; $i++){
                            $table['title'] = $lessonsTitle[$i];
                            $table['content'] = $lessonsContent[$i];
                            $table['video'] = $lessonsVideo[$i];
                            $table['position'] = $_POST['lessonOrder'][$i];
                            $table['formationId'] = $formationId;
                            $table['sectionId'] = $sectionId;
                        array_push($lessons, $table);
                        }
    
                        //2. je boucle sur le tableau et insére les leçons
                        // Si les leçons existent déjà, je les met à jour
                        // Si les leçons n'existe pas, qu'il faut les créer, je les insère.
                        if(isset($allLessons)){
                            foreach($lessons as $lesson){
                                $this->lessonManager->updateLessonInBdd($lesson);
                            }
                        } else {
                            foreach($lessons as $lesson){
                                $this->lessonManager->addLessonInBdd($lesson);
                            }
                        }
    
                        //3. redirection vers le panneau de modification
                        header("location: ". URL . "teacherEspace/modify/".$formationId);
                    }
                }
            }
        }
        require_once(ROOT.'/views/teacher/formation-modify-step.view.php');
    }

    public function deleteSection($formationId, $sectionId){
        // supprime section et lesson rattaché 
        if($this->lessonManager->deleteLessonOfSectionInBdd($sectionId) === true){
            if($this->sectionManager->deleteOneSectionInBdd($sectionId) === true){
                // modifie la position de toutes les sections, réinitialise à 1;
                $this->sectionManager->loadSections();
                $sectionsId = $this->sectionManager->getSectionsIdByFormation($formationId);
                $this->sectionManager->updateSectionPosition($formationId, $sectionsId);
                    
                header("location: ". URL . "teacherEspace/modify/".$formationId);
            }   
        }   
    }

    public function deleteFormation($formationId){
        // si cette formation n'appartient pas au formateur ou est en ligne, erreur
        $teacherId = $_SESSION['id'];
        $this->formationManager->loadFormations();
        $formationsIdPossible = $this->formationManager->getformationsNotOnlineIdByTeacherId($teacherId);
        if(!in_array($formationId, $formationsIdPossible)){
            throw new Exception('vous ne pouvez pas supprimer cette formation');
        } else {
            if($this->lessonManager->deleteLessonsOfFormationInBdd($formationId) === true){
                if($this->sectionManager->deleteSectionsOfFormationInBdd($formationId) === true){
                    $this->formationManager->loadFormations();
                    $picture = $this->formationManager->getFormationById($formationId)->getPicture();
                    if($this->formationManager->deleteFormationInBdd($formationId) === true){
                        unlink($picture);
                        $_SESSION['alert'] = [
                            "type" => "success",
                            "msg" => "La formation a été supprimé."         
                    ];
                    } else {
                        $_SESSION['alert'] = [
                            "type" => "danger",
                            "msg" => "La formation n'a pas put être supprimé."       
                    ];
                    }
                }
            }
            header('Location: '. URL . "teacherEspace");
        }   
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
    
    public function ajaxUpdateLessonAndFormationStatus($studentId, $lessonId, $formationId, $status){
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


