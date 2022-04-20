<?php
ob_start();
?>

    <main>
        <a href="<?= URL ?>adminEspace" class="btn button-general button-type-1">Retour</a>
        <h2 id="formation-title" class="m-4"><?= $formation->getTitle(); ?></h2>

        <div id="container-main-formation">
            <div id="container-formation">
                <div id="menu-formation">
                    <div id="box-menu-formation">
                        <div id="menu-formation-title">
                            <span id="formation-menu-chapter">Sommaire</span>
                            <div id="menu-burger-exit">
                                <img src="<?= URL ?>public/images/general/menu-exit.png" alt="">
                            </div>
                        </div>
                        <?php foreach($menuFormation as $menu){ ?>
                            <span class="menu-formation-section"><?=  $menu['sectionTitle'] ?></span>
                            <?php foreach($menu['lessons'] as $lesson){?>
                                <a href="<?= URL ?>adminEspace/formation/<?= $menu['formationId'].'/'.$lesson->getId() ?>" <?php if($lesson->getId() === $lessonContent['lessonId']){ ?> class="menu-formation-lesson lesson-active" <?php } else { ?> class="menu-formation-lesson" <?php } ?>class="menu-formation-lesson"><?= $lesson->getTitle() ?></a>
                            <?php } ?>
                        <?php } ?> 

                    </div>
                </div>
        
                <div id="box-formation"class="d-flex flex-column align-items-center pb-4">
                
                    <div id="formation-box-section-title">
                        <h3><?= $lessonContent['sectionTitle'] ?></h3>
                    </div>
                    
                    <div id="formation-box-arrow">
                        <div id="menu-burger-show">
                            <img src="<?= URL ?>public/images/general/menu-show.png" alt="">
                        </div>
                        <div id="formation-button-arrow">
                            <?php if($lessonContent['lessonId'] !== $firstLessonId){ ?>
                                <a href="<?= URL ?>adminEspace/formation/<?= $menu['formationId'].'/'.$lessonContent['lessonId']-1 ?>" class="btn button-general button-type-1">précédent</a>
                            <?php } ?>
                            
                            <?php if($lessonContent['lessonId'] !== $lastLessonId){ ?>
                                <a href="<?= URL ?>adminEspace/formation/<?= $menu['formationId'].'/'.$lessonContent['lessonId']+1 ?>" class="btn button-general button-type-1">Suivant</a>
                            <?php } ?>
                        </div>
                    </div>

                    <div id="formation-box-lesson-title">
                        <h4><?= $lessonContent['lessonTitle'] ?></h4>
                    </div>

                    <div id="formation-box-video">
                        <iframe src="<?=$lessonContent['lessonvideo'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                
                    <div id="formation-box-content" class="px-3">
                        <p><?=$lessonContent['lessonContent'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>


<?php
$content = ob_get_clean();

$titleHead = 'Formation EcoIt';
$src = 'script\general\menuFormation.js';

require "views/common/template.view.php";
