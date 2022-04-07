<?php
ob_start();
?>



<div class="d-flex flex-column align-items-center m-4">
   <?= $essai ?>
    

</div>

<?php
$content = ob_get_clean();


require "views/common/template.view.php";