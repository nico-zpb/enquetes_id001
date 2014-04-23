<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 11:49
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


include_once "../../../datas/all.php";
include_once "../../../php/functions.php";

if(!isConnected()){
    header("Location: /index.php");
    die();
}


// verif arrive par post
if(!isPost() || !postExists("form_cw_range")){
    header("Location: /index.php");
    die();
}


include_once "../../../php/header.php";
include_once "../../../php/navbar.php";

?>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
            </div>
            <div class="col-md-10">
                <h1>Statistiques</h1>
                <h2>Format Internet - Classique</h2>
            </div>
            <div class="col-md-10 col-md-offset-2"></div>
        </div>
    </div>
</div>
