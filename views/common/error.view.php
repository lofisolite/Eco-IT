<?php
ob_start();
?>

<br>

<div id="errorPageDiv" class="d-flex flex-column align-items-center ">
    <h2>Oups ! Il y a une erreur</h2>
    <br>
    <h4><?= $ErrorMsg ?></h4>
    <br>
    <a href="<?= URL ?>accueil" type="button" class="btn button-general button-type-1">Retour à l'accueil</a>
</div>

<?php
$content = ob_get_clean();

/*
$preContent = "";
$titleHead = "Erreur Corespions";
$src = "";
*/

require "views/common/template.view.php";