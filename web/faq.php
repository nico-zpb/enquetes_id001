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