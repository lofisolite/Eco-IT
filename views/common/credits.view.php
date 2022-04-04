<?php
ob_start();

?>
<main>
    <h2>Crédits Images</h2>

    <div class="m-5 d-flex justify-content-center credits">
        <div class="m4 d-flex flex-column">
            <h4 class="text-center">Nom photographe</h4>
            <img src="" alt="">
        </div>
        <div class="m4 d-flex flex-column">
            <h4 class="text-center">Nom photographe</h4>
            <img src="" alt="">
        </div>
        <div class="m4 d-flex flex-column">
            <h4 class="text-center">Nom photographe</h4>
            <img src="" alt="">
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="m4 d-flex flex-column">
            <h4 class="text-center">Nom photographe</h4>
            <img src="" alt="">
        </div>
        <div class="m4 d-flex flex-column">
            <h4 class="text-center">Nom photographe</h4>
            <img src="" alt="">
        </div>
    </div>

    </main>

    <?php

    $content = ob_get_clean();

    require "views/common/template.view.php";