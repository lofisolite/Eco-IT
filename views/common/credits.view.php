<?php
ob_start();

?>
<main>
    <h2 class="mt-4">Crédits Images</h2>

    <div class="mt-5 d-flex justify-content-center credits">
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://unsplash.com/photos/IF9TK5Uy-KI">Jake Nackos</a></h4>
            <img src="public/images\teacher\Femme 1.jpg" alt="">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://unsplash.com/photos/fHXpgMd_XhE">Olia Nayda</a></h4>
            <img src="public/images\teacher\Homme 1.jpg" alt="">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://unsplash.com/photos/eSjmZW97cH8">Reza Biazar</a></h4>
            <img src="public/images\teacher\Homme 2.jpg" alt="">
        </div>
    </div>

    <div class="m-5 d-flex justify-content-center credits">
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://unsplash.com/photos/_5_CBVCLBsY">Christina</a></h4>
            <img src="public/images\teacher\Femme 2.jpg" alt="">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://unsplash.com/photos/c_GmwfHBDzk">Sergio de Paula</a></h4>
            <img src="public/images\teacher\Homme 3.jpg" alt="">
        </div>
    </div>

    <div class="mt-5 d-flex justify-content-center icons">
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://www.flaticon.com/authors/hqrloveq">hqrloveq</a></h4>
            <img src="<?= URL ?>images/general/gps.png" alt="">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://www.flaticon.com/authors/creaticca-creative-agency">Creatica</a></h4>
            <img src="<?= URL ?>images/general/phone.png" alt="">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://www.flaticon.com/authors/freepik">freepik</a></h4>
            <img src="<?= URL ?>images/general/arobas.png">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://www.flaticon.com/authors/freepik">freepik</a></h4>
            <img src="<?= URL ?>images/general/facebook.png" alt="">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://www.flaticon.com/authors/freepik">freepik</a></h4>
            <img src="<?= URL ?>images/general/instagram.png" alt="">
        </div>
        <div class="m-4 d-flex flex-column">
            <h4 class="text-center"><a target="_blank" href="https://www.flaticon.com/fr/auteurs/riajulislam">riajulislam</a></h4>
            <img src="<?= URL ?>images/general/twitter.png" alt="">
        </div>
    </div>

</main>

<?php

$titleHead = 'credits EcoIt';
$content = ob_get_clean();

require "views/common/template.view.php";