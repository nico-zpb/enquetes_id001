<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 11:50
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
if(!isPost() || !postExists("form_cwm_range")){
    header("Location: /index.php");
    die();
}

$form = getPost("form_cwm_range");
$today = new DateTime("now");

$annee = $form["annee"];
$monthStart = $form["month_start"];
$monthEnd = $form["month_end"];

// erreur sur mois






$monthStartName = $datas_mois[$monthStart - 1];
$monthEndName = $datas_mois[$monthEnd - 1];


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
                <h2>Format Internet - Données par mois</h2>
            </div>
            <div class="col-md-10 col-md-offset-2"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Période </h1>
            </div>
        </div>
    </div>
</div>
