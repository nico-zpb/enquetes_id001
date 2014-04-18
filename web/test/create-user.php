<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 18/04/14
 * Time: 13:37
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

include_once "../../php/functions.php";
include_once ROOT . "/php/enquete-connexion.php";
$passLib = new \PasswordLib\PasswordLib();
$username = "nicolas";
$password = "admin";
$hash = $passLib->createPasswordHash($password);
$email = "nicolas.canfrere@zoobeauval.com";

$sql = "INSERT INTO users (pseudo, password, email) VALUES (:pseudo, :password, :email)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":pseudo", $username);
$stmt->bindValue(":password", $hash);
$stmt->bindValue(":email", $email);

$stmt->execute();