<?php
ob_start();
?>

<main id="main-admin">
    
    <div class="container-intro-espace" class="d-flex flex-column align-items-center">
        <p>Bonjour Martin</p>
        <h2>Gestion des formateurs</h2>
    </div>  
    <div class="container-main">
    <h3>Non validés</h3>
        <div class="container-admin">
            <table id="table1" class="table text-center">
                <tr>
                    <th>Nom</th>
                    <th>Décisions</th>
                    <th></th>
                </tr>
                <tr>
                    <td class="cell-border-right align-middle">John Doe</td>
                    <td class="cell-border-right align-middle">
                        <a class="btn button-general btn-choice-valid" href="">Valider</a>
                        <a class="btn button-general btn-choice-reject" href="">Rejeter</a>
                    </td>
                    <td class="align-middle"><a class="btn button-general button-type-2" href="">Détails</a></td>
                </tr>
                <tr>
                    <td class="cell-border-right align-middle">Sabrina Durand</td>
                    <td class="cell-border-right align-middle">
                        <a class="btn button-general btn-choice-valid" href="">Valider</a>
                        <a class="btn button-general btn-choice-reject" href="">Rejeter</a>
                    </td>
                    <td class="align-middle">
                        <a class="btn button-general button-type-2" href="">Détails</a>
                    </td>
                </tr>
                <tr>
                    <td class="cell-border-right align-middle">Fabrice Ramolos</td>
                    <td class="cell-border-right align-middle">
                        <a class="btn button-general btn-choice-valid" href="">Valider</a>
                        <a class="btn button-general btn-choice-reject" href="">Rejeter</a>
                    </td>
                    <td class="align-middle">
                        <a class="btn button-general button-type-2" href="">Détails</a>
                    </td>
                </tr>
            </table>
        </div>

        <h3>Validés</h3>
        <div class="container-admin">
            <table  id="table2" class="table text-center">
                <tr>
                    <th>Nom</th>
                    <th></th>
                </tr>
                <tr>
                    <td class="cell-border-right align-middle">Damien Sarrazin</td>
                    <td class="align-middle">
                        <a class="btn button-general button-type-2" href="">Détails</a></td>
                </tr>
                <tr>
                    <td class="cell-border-right align-middle">Antoine Daniel</td>
                    <td class="align-middle">
                        <a class="btn button-general button-type-2" href="">Détails</a>
                    </td>
                </tr>
                <tr>
                    <td class="cell-border-right align-middle">Natasha Brandon</td>
                    <td class="align-middle">
                        <a class="btn button-general button-type-2" href="">Détails</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <div class="container-intro-espace">
        <h2>Détails des formateurs</h2>
    </div>
        
    <div class="container-main">
        <div onclick="upPage()" id="divButton">
            <button id="btn-up-page">Haut</button>
        </div>
        <h3>Non validés</h3>
        <div class="container-admin">
            <div class="container-cards" class="d-flex justify-content-center">
                <div id="container-card">

                    <div id="box-container-card" class="d-flex flex-column align-items-center">

                        <div id="" class="card-box" class="d-flex flex-column align-items-center">
                            
                            <div class="card-identity">
                                <div class="card-title">
                                    <h4>Florian Fleur</h4>
                                </div>
                                <img class="picture-profile" src="https://picsum.photos/500/500" alt="">
                            </div>

                            <div class="card-box-main">
                                <div class="card-box-description">
                                    <p class="fw-bold">JohnDoe@mail.fr</p>
                                    <p class="card-description">Cette formation a pour but de vous faire acquérir des bonnes pratiques dans la réalisation d'un site web afin de réduire son impact environnemental. En passant par les phases d'analyses, de maquettage et enfin de réalisation, vous avancerez pas à pas dans la conception de votre site.</p>
                                </div>
                            </div>

                            <div class="card-box-footer">
                                <div class="d-flex justify-content-center m-3">
                                    <a class="btn button-general btn-choice-valid" href="">Valider</a>
                                    <a class="btn button-general btn-choice-reject" href="">Rejeter</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h3>Validés</h3>
        <div class="container-admin">
            <div class="container-cards" class="d-flex justify-content-center">
                <div id="container-card">

                    <div id="box-container-card" class="d-flex flex-column align-items-center">

                        <div id="" class="card-box" class="d-flex flex-column align-items-center">
                            
                            <div class="card-identity">
                                <div class="card-title">
                                    <h4>Florian Fleur</h4>
                                </div>
                                <img class="picture-profile" src="https://picsum.photos/500/500" alt="">
                            </div>

                            <div class="card-box-main">
                                <div class="card-box-description">
                                    <p class="fw-bold">JohnDoe@mail.fr</p>
                                    <p class="card-description">Cette formation a pour but de vous faire acquérir des bonnes pratiques dans la réalisation d'un site web afin de réduire son impact environnemental. En passant par les phases d'analyses, de maquettage et enfin de réalisation, vous avancerez pas à pas dans la conception de votre site.</p>
                                </div>
                            </div>

                            <div class="card-box-footer">
                                <p class="text-center"><span>Ses formations</span></p>
                                <p class="text-center">les bonnes pratiques en front-end</p>
                                <p class="text-center">les bonnes pratiques en back-end</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</main>

<?php

$content = ob_get_clean();

require "views/common/template.view.php";