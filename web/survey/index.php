<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 18/04/14
 * Time: 10:01
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
include_once "../../datas/all.php";
include_once "../../php/functions.php";

if(!isConnected()){
    header("Location: /index.php");
    die();
}

include_once "../../php/header.php";
include_once "../../php/navbar.php";

?>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
            </div>
            <div class="col-md-10">
                <h1>Statistiques</h1>
            </div>
            <div class="col-md-10 col-md-offset-2"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Format Internet</h2>
                <p>Retrouvez toutes les données des enquêtes sur votre écran. </p>
                <p><a class="btn btn-hotel" href="/survey/to-web.php">continuer &raquo;</a></p>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Format Excel</h2>
                <p>Téléchargez vos données au format Excel</p>
                <p><a class="btn btn-hotel" href="/survey/to-excel.php">continuer &raquo;</a></p>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Format PDF</h2>
                <p>Exportez en PDF</p>
                <p><a class="btn btn-hotel" href="/survey/to-pdf.php">continuer &raquo;</a></p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <hr/>
    <footer>
        <p>&copy; ZooParc de Beauval 2014</p>
    </footer>
</div>


</body>
</html>


