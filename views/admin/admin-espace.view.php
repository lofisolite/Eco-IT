<?php
ob_start();

?>

<main id="main-admin">
    
    <div class="container-intro-espace" class="d-flex flex-column align-items-center">
        <p class="welcome-text"><?= 'Bonjour '.$_SESSION['fn'] ?></p>
        <div class="text-explication">
            <p class="text-align">Dans la partie "gestion des formateurs, vous avez un tableau contenant les formateurs non validés et un tableau contenant les formateurs validés."</p>
            <p class="text-align">Si vous validez un formateur, il aura accès à son espace et pourra créer des formations. Si vous ne validez pas un formateur, il sera supprimé de la base de donnée.</p>
            <br>
        </div>
        <?php if(!empty($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['alert']['type'] ?>" role="alert">
            <p><?= $_SESSION['alert']['msg'] ?></p>
            </div>
        <?php unset($_SESSION['alert']);
        endif; ?>

        <h2>Gestion des formateurs</h2>
    </div>  

    <div class="container-main">
        <h3>Non validés</h3>
        <div class="container-admin">
            <?php if(isset($teachersNotValidate)){ ?>

            <table id="table1" class="table text-center">
                <tr>
                    <th>Nom</th>
                    <th>Décisions</th>
                    <th></th>
                </tr>
                <?php foreach($teachersNotValidate as $teacher):?>
                <tr>
                    <td class="cell-border-right align-middle"><?= $teacher->getFirstname().' '.$teacher->getLastname(); ?></td>

                    <td class="cell-border-right align-middle">

                        <div class="admin-choice">
                            <form method="POST" action="<?= URL ?>adminEspace/validate/<?= $teacher->getId(); ?>" onSubmit="return confirm('voulez vous vraiment valider le formateur?');">
                                <button type="submit" class="btn button-general btn-choice-valid">Valider</button>
                            </form>

                            <form method="POST" action="<?= URL ?>adminEspace/reject/<?= $teacher->getId(); ?>" onSubmit="return confirm('voulez vous vraiment rejeter le formateur?');">
                                <button type="submit" class="btn button-general btn-choice-reject">Rejeter</button>
                            </form>
                        </div>

                    </td>
                    <td class="align-middle">
                        <a class="btn button-general button-type-2" href="<?= '#card'.$teacher->getId(); ?>">Détails</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php } else { ?>
                <div class="box-welcome-text">
                    <p class="welcome-text">Il n'y a pas de formateur à valider.</p>
                </div>
            <?php } ?>
        </div>

        <h3>Validés</h3>
        <div class="container-admin">

            <?php if(isset($teachersValidateTable)){ ?>
            <table id="table2" class="table text-center">
                <tr>
                    <th>Nom</th>
                    <th></th>
                </tr>
                <?php foreach($teachersValidateTable as $teacher):?>
                <tr>
                    <td class="cell-border-right align-middle"><?= $teacher['firstname'].' '.$teacher['lastname']; ?></td>
                    <td class="align-middle">
                        <a class="btn button-general button-type-2" href="<?= '#card'.$teacher['id'] ?>">Détails</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php } else { ?>
                <div class="box-welcome-text">
                    <p class="welcome-text">Il n'y a pas de formateur validé.</p>
                </div>
            <?php } ?>

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
        <?php if(isset($teachersNotValidate)){ ?>
        <div class="container-admin">
            <div class="container-cards-teacher">
                <div id="container-card">

                <?php foreach($teachersNotValidate as $teacher):?>
                    <div id="box-container-card" >

                        <div id="<?= 'card'.$teacher->getId(); ?>" class="card-box">
                            
                            <div class="card-identity">
                                <div class="card-title">
                                    <h4><?= $teacher->getFirstname().' '.$teacher->getLastname(); ?></h4>
                                </div>
                                <img class="picture-profile" src="<?= $teacher->getPictureProfile(); ?>" alt="">
                            </div>

                            <div class="card-box-main">
                                <div class="card-box-description">
                                    <p class="fw-bold"><?= $teacher->getMail(); ?></p>
                                    <p class="card-description"><?= $teacher->getDescription(); ?></p>
                                </div>
                            </div>

                            <div class="card-box-footer">
                                <div class="d-flex justify-content-center m-3">
                                    <form method="POST" action="<?= URL ?>adminEspace/validate/<?= $teacher->getId(); ?>" onSubmit="return confirm('voulez vous vraiment valider le formateur?');">
                                        <button type="submit" class="btn button-general btn-choice-valid">Valider</button>
                                    </form>
                                    
                                    <form method="POST" action="<?= URL ?>adminEspace/reject/<?= $teacher->getId(); ?>" onSubmit="return confirm('voulez vous vraiment supprimer le formateur?');">
                                        <button type="submit" class="btn button-general btn-choice-reject">Rejeter</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php } else { ?>
            <div class="box-welcome-text">
                <p class="welcome-text">Il n'y a pas de formateur non validé.</p>
            </div>
        <?php } ?>

        <h3>Validés</h3>
        <?php if(isset($teachersValidateTable)){ ?>
        <div class="container-admin">
            <div class="container-cards-teacher">

                <?php foreach($teachersValidateTable as $teacher){?>
                    
                <div id="box-container-card">
                    <div id="<?= 'card'.$teacher['id'] ?>" class="card-box">
                            
                        <div class="card-identity">
                            <div class="card-title">
                                <h4><?= $teacher['firstname'].' '.$teacher['lastname'] ?></h4>
                            </div>
                            <img class="picture-profile" src="<?= $teacher['picture'] ?>" alt="">
                        </div>

                        <div class="card-box-main">
                            <div class="card-box-description">
                                <p class="fw-bold"><?= $teacher['mail'] ?></p>
                                <p class="card-description"><?= $teacher['description'] ?></p>
                            </div>
                        </div>

                        <div class="card-box-footer">
                            <p class="text-center"><span>Ses formations</span></p>
                            <?php if(isset($teacher['formations'])){ 
                                foreach($teacher['formations'] as $formation){?>
                                    <p class="text-center" ><a href="<?= URL ?>adminEspace/formation/<?= $formation->getId() ?>" ><?= $formation->getTitle() ?></a></p>
                                <?php }
                            } else { ?>
                            <p class="text-center font-italic" >Ce formateur n'a pas encore de formation en ligne</p>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                
                </div>
            </div>
        </div>
        <?php } else { ?>
            <div class="box-welcome-text">
                <p class="welcome-text">Il n'y a pas de formateur validé.</p>
            </div>
        <?php } ?>


    </div>

</main>

<?php
$content = ob_get_clean();

$titleHead = 'Espace administrateur';
$src = "script/general/script.admin.js";

require "views/common/template.view.php";