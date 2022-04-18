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
        <table id="table1" class="table text-center">
                <tr>
                    <th>Sections</th>
                    <th>Décisions</th>
                </tr>
                
                <?php foreach($sections as $section):?>
                <tr>
                    <td class="cell-border-right align-middle"><?= $section->getTitle(); ?></td>

                    <td class="cell-border-right align-middle">

                        <div class="admin-choice">
                            <button type="submit" class="btn button-general btn-choice-valid">Modifier</button>
                            

                            <form method="POST" action="<?= URL ?>adminEspace/reject/<?= $formation->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer cette section?');">
                                <button type="submit" class="btn button-general btn-choice-reject">supprimer</button>
                            </form>
                        </div>

                    </td>
                   
                </tr>
                <?php endforeach; ?>
            </table>
    </main>

<?php

$content = ob_get_clean();

$titleHead = 'Modification formation';
//$src = "script/form/verifyFormFormation.js";
//$src2 = "script/form/addFormation.js";

require "views/common/template.view.php";