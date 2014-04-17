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
$isConnected = false;
if(isset($_SESSION["user"]) && $_SESSION["user"] != null){
    $isConnected = true;
}


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

        </div>
        <div class="col-md-3">

        </div>
    </div>


    <hr>

    <footer>
        <p>&copy; ZooParc de Beauval 2014</p>
    </footer>
</div> <!-- /container -->