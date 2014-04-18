<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 17/04/14
 * Time: 16:48
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
                <h1>Connexion</h1>
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

        </div>
        <div class="col-md-4">
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur, ou adresse email :</label>
                    <input type="text" name="form_login[username]" id="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="form_login[password]" id="password" class="form-control"/>
                </div>
                <button type="submit" class="btn btn-hotel">Connexion</button>
            </form>
        </div>
        <div class="col-md-4">

        </div>
    </div>

    <hr>

    <footer>
        <p>&copy; ZooParc de Beauval 2014</p>
    </footer>
</div> <!-- /container -->
</body>
</html>