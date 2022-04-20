<?php
ob_start();

print_r($essai);

?>

<?php

$content = ob_get_clean();

$titleHead = 'test';
//$src = "script/form/verifyFormFormation.js";
$src2 = "script/form/addFormation.js";

require "views/common/template.view.php";