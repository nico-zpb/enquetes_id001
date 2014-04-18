<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 18/04/14
 * Time: 14:28
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
session_start();

include_once "../../php/functions.php";

if(!isConnected()){
    header("Location: /index.php");
    die();
}

include_once "../../php/header.php";
include_once "../../php/navbar.php";

$error = [];
$success = false;
if(isPost() && postExists("newpass_form")){
    $datas = getPost("newpass_form");
    if($datas["newpass_first"] !== $datas["newpass_second"]){
        $error["pass_not_equals"] = "Les deux nouveaux mots de passe ne sont pas identiques.";
    } else {
        include_once ROOT . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "enquete-connexion.php";
        $username = $_SESSION["user"]["username"];
        $passLib = new \PasswordLib\PasswordLib();


        // user exists ?

        $sql = "SELECT * FROM users WHERE pseudo=:username LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if($user && $passLib->verifyPasswordHash($datas["oldpass"], $user["password"])){

            $newPass = $passLib->createPasswordHash($datas["newpass_first"]);

            $sql = "UPDATE users SET password=:pass WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":pass", $newPass);
            $stmt->bindValue(":id", $user["id"]);
            $stmt->execute();
            $success = true;

        } else {

        }
    }

}

?>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
            </div>
            <div class="col-md-10">
                <h1>Mon compte</h1>
            </div>
            <div class="col-md-10 col-md-offset-2">

            </div>
        </div>

    </div>
</div>
<div class="container">
    <?php if($error): ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-danger">
                    <?php if($error["pass_not_equals"]): ?>
                    <strong>Problème</strong> <?php echo $error["pass_not_equals"]; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($success): ?>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-success">
                <strong>OK !</strong> Votre mot de passe à bien été réinitialisé.
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h2>Modifier mon mot de passe</h2>

            <form action="" method="post">

                <div class="form-group">
                    <label for="oldpass">Votre mot de passe actuel :</label>
                    <input type="password" name="newpass_form[oldpass]" id="oldpass" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="newpass_first">Votre nouveau mot de passe :</label>
                    <input type="password" name="newpass_form[newpass_first]" id="newpass_first" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="newpass_second">Répétez votre nouveau mot de passe :</label>
                    <input type="password" name="newpass_form[newpass_second]" id="newpass_second" class="form-control"/>
                </div>
                <button type="submit" class="btn btn-hotel">Enregistrer</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>