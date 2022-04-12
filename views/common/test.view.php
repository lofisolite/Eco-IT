<?php
ob_start();


?>


<br>




<?php
$content = ob_get_clean();

$src = '';

require "views/common/template.view.php";
