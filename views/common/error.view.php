<?php
ob_start();
?>

<br>

<div id="errorPageDiv" class="d-flex flex-column align-items-center ">
    <h2>Oups ! Il y a une erreur</h2>
    <br>
    <h4><?= $errorMsg ?></h4>
    <br>
    <a href="<?= URL ?>accueil" type="button" class="btn button-general button-type-1">Retour à l'accueil</a>

    <?php if(isset($_SESSION["access"])){
        if($_SESSION["access"] === 'admin'){ ?>
            <a type="button" class="btn button-general button-type-1" href="<?= URL ?>adminEspace">Mon espace</a>
        <?php } else if($_SESSION["access"] === 'student'){ ?>
            <a type="button" class="btn button-general button-type-1" href="<?= URL ?>studentEspace">Mon espace</a>
        <?php } else if($_SESSION["access"] === 'teacher'){ ?>
            <a type="button" class="btn button-general button-type-1" href="<?= URL ?>teacherEspace">Mon espace</a>
        <?php }
    } ?>

</div>

<?php
$content = ob_get_clean();


$titleHead = "Erreur";


require "views/common/template.view.php";