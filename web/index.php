<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 29/03/2014
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


include_once "../php/functions.php";


include_once "../php/header.php";

include_once "../php/navbar.php";
?>



<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
   <div class="container">
       <div class="row">
           <div class="col-md-2">
               <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
           </div>
           <div class="col-md-10">
               <h1>Enquêtes Clientèle</h1>
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
       <div class="col-md-6">
           <h2>Saisie des enquêtes clientèle</h2>
           <p>Dans cette section est réservée à l'enregistrement des formulaires papier remplis par la clientèle.</p>
           <p><a class="btn btn-default" href="/enregistement.php" role="button">Enregistrer &raquo;</a></p>
       </div>
       <div class="col-md-6">
           <h2>Consultation des statistiques</h2>
           <p>Dans cette section est réservée à la consultation des statistiques tirées des enregistrements des enquêtes.</p>
           <?php if(isConnected()): ?>
           <p><a class="btn btn-default" href="/survey/index.php" role="button">Voir les statistiques &raquo;</a></p>
           <?php else: ?>
           <p><a class="btn btn-default" href="/login.php" role="button">Connexion &raquo;</a></p>
           <?php endif; ?>
       </div>
   </div>

   <hr>

   <footer>
       <p>&copy; ZooParc de Beauval 2014</p>
   </footer>
</div> <!-- /container -->
</body>
</html>
