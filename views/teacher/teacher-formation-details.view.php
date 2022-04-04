<?php
ob_start();
?>

    <main>
        <a href="mesformations-apprenant.view.php" class="btn button-general button-type-1">Retour aux formations</a>
        <h2 id="formation-title" class="text-center">Les bonnes pratiques en front-end</h2>
        <p class="text-center">Formateur : Jean-louis</p>

        <div id="container-main-formation">
            <div id="container-formation" class="d-flex justify-content-between">
                <div id="menu-formation" class="">
                    <div id="box-menu-formation">
                        <div id="menu-formation-title">
                            <span id="formation-menu-chapter">Menu</span>
                            <div id="menu-burger-exit">
                                <img src="images/menu-exit.png" alt="">
                            </div>
                        </div>
                        
                        <span class="menu-formation-section">les bonnes pratiques en HTML</span>
                        <a class="menu-formation-lesson">les balises</a>
                        <a class="menu-formation-lesson">la balise meta</a>
                        <a class="menu-formation-lesson">les images</a>
                        <a class="menu-formation-lesson">les attributs</a>
                        <span class="menu-formation-section">Les bonnes pratiques en CSS</span>
                        <a class="menu-formation-lesson">les selecteurs</a>
                        <a class="menu-formation-lesson">bootstrap</a>
                        <a class="menu-formation-lesson">gestion des images</a>
                        <span class="menu-formation-section">Les bonnes pratiques en JavaScript</span>
                        <a class="menu-formation-lesson">les boucles</a>
                        <a class="menu-formation-lesson">Les blocs try... catch</a>
                        <a class="menu-formation-lesson">les structures de conditions</a>
                    </div>
                </div>
        
                <div id="box-formation"class="d-flex flex-column align-items-center">
                
                    <div id="formation-box-section-title">
                        <h3>Les bonnes pratiques en HTML</h3>
                    </div>
                    
                    <div id="formation-box-arrow">
                        <div id="menu-burger-show">
                            <img src="images/menu-show.png" alt="">
                        </div>
                        <div id="formation-button-arrow">
                            <a class="btn button-general  button-type-1">précédent</a>
                            <a class="btn button-general  button-type-1">suivant</a>
                        </div>
                    </div>

                    <div id="formation-box-lesson-title">
                        <h4>Les balises</h4>
                    </div>

                    <div id="formation-box-video">
                        <iframe src="https://www.youtube.com/embed/bRbtTCYbU6c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                
                    <div id="formation-box-content" class="px-3">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus vestibulum mattis ullamcorper velit. Bibendum arcu vitae elementum curabitur vitae nunc sed velit. Diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget. Ut aliquam purus sit amet luctus venenatis lectus magna fringilla. Venenatis tellus in metus vulputate.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus vestibulum mattis ullamcorper velit. Bibendum arcu vitae elementum curabitur vitae nunc sed velit. Diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget. Ut aliquam purus sit amet luctus venenatis lectus magna fringilla. Venenatis tellus in metus vulputate.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus vestibulum mattis ullamcorper velit. Bibendum arcu vitae elementum curabitur vitae nunc sed velit. Diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget. Ut aliquam purus sit amet luctus venenatis lectus magna fringilla. Venenatis tellus in metus vulputate.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus vestibulum mattis ullamcorper velit. Bibendum arcu vitae elementum curabitur vitae nunc sed velit. Diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget. Ut aliquam purus sit amet luctus venenatis lectus magna fringilla. Venenatis tellus in metus vulputate.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus vestibulum mattis ullamcorper velit. Bibendum arcu vitae elementum curabitur vitae nunc sed velit. Diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget. Ut aliquam purus sit amet luctus venenatis lectus magna fringilla. Venenatis tellus in metus vulputate.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus vestibulum mattis ullamcorper velit. Bibendum arcu vitae elementum curabitur vitae nunc sed velit. Diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget. Ut aliquam purus sit amet luctus venenatis lectus magna fringilla. Venenatis tellus in metus vulputate.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lectus vestibulum mattis ullamcorper velit. Bibendum arcu vitae elementum curabitur vitae nunc sed velit. Diam donec adipiscing tristique risus nec. Sit amet venenatis urna cursus eget. Ut aliquam purus sit amet luctus venenatis lectus magna fringilla. Venenatis tellus in metus vulputate.</p>
                    </div>

                    <div id="formation-box-resource">
                        <p>les ressources :</p> 
                    </div>
                    
                </div>
            </div>
        </div>
    </main>
    
<?php

$content = ob_get_clean();

require "views/common/template.view.php";