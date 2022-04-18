<?php
ob_start();
/*
echo '<pre>';
print_r($essai);
echo '</pre>';
*/
//$test = end($formations);
echo '<pre>';
print_r($formationsIdPossible);
echo '</pre>';
?>

<?php

$content = ob_get_clean();

$titleHead = 'Ajout formation';
//$src = "script/form/verifyFormFormation.js";
$src2 = "script/form/addFormation.js";

require "views/common/template.view.php";