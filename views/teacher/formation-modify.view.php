<?php
ob_start();
?>

<main class="mt-4" id="formation-creation">
    <a href="<?= URL ?>teacherEspace" class="btn button-general button-type-1">Retour</a>
    <main class="mt-4" id="formation-creation">
        <h2>Modifier votre formation</h2>
        <h3>Les éléments généraux</h3>

        <div id="container-modify-element">
            <div class="card-box-intro">
                <h4><?= $formation->getTitle();?></h4>
            </div> 
                
            <div class="card-box-main">
            <img src="<?= URL.$formation->getPicture();?>" class="card-img-modify">
            </div>

            <div class="card-box-main">
                <p><?= $formation->getDescription();?></p>
            </div>
            <div class="card-box-main">
                <a href="<?= URL ?>teacherEspace/modify/<?= $formation->getId();?>/general" type="submit" class="btn button-general btn-choice-valid">Modifier</a>
            </div>
        </div>

        <h3>Les sections</h3>
        <table id="table3" class="table text-center">
            <tr>
                <th>Sections</th>
                <th>Nombre de leçons</th>
                <th>Décisions</th>
            </tr>
                
            <?php foreach($existingSectionElements as $section):?>
            <tr>
                <td class="cell-border-right align-middle oldSectionTitle"><?= $section['title']; ?></td>
                
                <?php if($section['nbrLessonCreated'] === 0){ ?>
                    <td>
                        <p>Il y a <?= $section['nbrLesson']?> leçons à créer</p>
                    </td>
                <?php } else { ?>
                    <td><?= $section['nbrLesson'] ?></td>
                <?php } ?>
                
                <td class="align-middle">

                    <div class="admin-choice">
                        <a class="btn button-general btn-choice-valid align-self-center" href="<?= URL ?>teacherEspace/modify/<?= $formation->getId();?>/step/<?= $section['position'] ?>">Modifier</a>
                        
                            
                        <form style="margin-block-end:0em" method="POST" action="<?= URL ?>teacherEspace/deleteSection/<?= $formation->getId(); ?>/<?= $section['id'] ?>" onSubmit="return confirm('voulez vous vraiment supprimer cette section?');">

                        <?php if($section['position'] !== 1) { ?>
                            <button type="submit" class="btn button-general btn-choice-reject">supprimer</button>
                        <?php } ?>
                        </form>
                    </div>

                </td>
                   
            </tr>
            <?php endforeach; ?>
        </table>
        
        <h3 class="mt-2">Ajouter des sections</h3>
            
        <form action="" method="POST" class="form d-flex flex-column justify-content-center" id="formModifyFormation">
            <div class="mb-3" id="containerSectionsModif">
                <input type="hidden" name="nbrSection" value="<?= count($sections) ?>">
               
            </div>
            
            <div class="d-flex justify-content-center">
                <a class="btn button-general btn-choice-valid" id="addSection">+ section</a>
                <a class="btn button-general btn-choice-reject" id="deleteSection">- section</a>
            </div>
            <button type="submit" class="btn button-general button-type-2 align-self-center">Valider</Button>
        </form>
    </main>

    <?php

    $content = ob_get_clean();

$titleHead = 'Modification formation';
$src = "script/form/modifyFormation/modifyFormation.js";

require "views/common/template.view.php";