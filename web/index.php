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


$isConnected = false;
if(isset($_SESSION["user"]) && $_SESSION["user"] != null){
   $isConnected = true;
}


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
       <div class="col-md-4">
           <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
           <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
       <div class="col-md-4">
           <h2>Heading</h2>
           <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
           <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
       <div class="col-md-4">
           <h2>Heading</h2>
           <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
           <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
   </div>

   <hr>

   <footer>
       <p>&copy; ZooParc de Beauval 2014</p>
   </footer>
</div> <!-- /container -->
</body>
</html>
