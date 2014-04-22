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

include_once "../php/functions.php";

if(isConnected()){
    header("Location: /survey/index.php");
    die();
}

$user = "test";

$error = null;
if(isPost() && postExists("login_form")){
    $user = "is post";
    include_once ROOT . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "enquete-connexion.php";
    $loginForm = getPost("login_form");
    $sql = "SELECT * FROM users WHERE pseudo=:username OR email=:username LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":username", $loginForm["username"]);
    $stmt->execute();
    $resultUSer = $stmt->fetch();
    if($resultUSer){
        $passLib = new \PasswordLib\PasswordLib();
        if($passLib->verifyPasswordHash($loginForm["password"], $resultUSer["password"])){
            $_SESSION["user"] = ["username"=>$resultUSer["pseudo"], "email"=>$resultUSer["email"]];
            header("Location: /index.php");
            die();
        } else {
            $error = true;
        }
    } else {
        $error = true;
    }
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
                <h1>Connexion</h1>
            </div>
            <div class="col-md-10 col-md-offset-2"></div>
        </div>

    </div>
</div>

<div class="container">
    <!-- Example row of columns -->
    <?php if($error): ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-danger">
                <strong>Problème</strong> Utilisateur inconnu ou mauvais identifiants !
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur, ou adresse email :</label>
                    <input type="text" name="login_form[username]" id="username" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="login_form[password]" id="password" class="form-control"/>
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