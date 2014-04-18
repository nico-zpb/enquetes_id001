<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 17/04/14
 * Time: 17:39
 */
  /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/

$page = "faq";
include_once "../php/functions.php";


include_once "../php/header.php";

include_once "../php/navbar.php";
?>

<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
            </div>
            <div class="col-md-10">
                <h1>FAQ</h1>
            </div>
            <div class="col-md-10 col-md-offset-2">

                <p><a class="btn btn-hotel btn-lg" role="button" href="/enregistement.php">Enregistrement des enquêtes <i class="fa fa-arrow-right"></i></a></p>
            </div>
        </div>

    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <div class="col-md-9">
            <h2>Raccourcis clavier</h2>

            <h4>Déplacements sur les champs</h4>

            <p>Touche tabulation pour avancer</p>
            <p>Touche majuscule + tabulation pour reculer</p>

            <h4>Séléctions</h4>

            <p>Case à cocher, à choix multiple : Touche espace pour séléctionner, à nouveau Touche espace pour déséléctionner.</p>
            <p>Case à cocher, à choix unique : Touche espace pour séléctionner, flèche haut, bas pour modifier.</p>
            <p>Menu déroulant : déplacement avec flèche haut, bas le texte apparant est le texte séléctionné.</p>

        </div>
        <div class="col-md-3">

        </div>
    </div>


    <hr>

    <footer>
        <p>&copy; ZooParc de Beauval 2014</p>
    </footer>
</div> <!-- /container -->