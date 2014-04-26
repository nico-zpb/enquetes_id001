<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 25/04/14
 * Time: 16:55
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
if(!isPost() || !postExists("form_cwg_range")){
    header("Location: /index.php");
    die();
}
$error = false;
$errorMsg = "<strong>Erreur</strong> ";

$form = getPost("form_cwg_range");
$dateForTodayMonth = new DateTime();
$annee = (int)$form["annee"];
$monthStart = 1;
$monthEnd = $dateForTodayMonth->format("n");

if($debug){
    $monthEnd = 12;
}

$period = "Pour l'année " . $annee;

$numEntry = 0;
include_once "../../../php/enquete-connexion.php";

$tmpDateStart = DateTime::createFromFormat("j-n-Y", "1-1-".$annee);
$tmpDateStartTs = $tmpDateStart->getTimestamp();

$tmpLastDayVal = DateTime::createFromFormat("j-n-Y", "1-". $monthEnd . "-" .$annee);
$tmpLastDay = $tmpLastDayVal->format("t");


$tmpDateEnd = DateTime::createFromFormat("j-n-Y",$tmpLastDay . "-". $monthEnd . "-" .$annee);
$tmpDateEndTs = $tmpDateEnd->getTimestamp();


$sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_timestamp>=:datestartts AND arrive_timestamp<=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $tmpDateStartTs);
$stmt->bindValue(":dateendts", $tmpDateEndTs);
$stmt->execute();
$numEntry = $stmt->fetch()["num"];
if(!$numEntry){
    setFlash("Il n'y a pas de résultats sur la période demandée.");
    header("Location: /survey/to-web.php");
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
                <h2>Format Internet - Données globales</h2>
            </div>
            <div class="col-md-10 col-md-offset-2"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h1><?php echo $period; ?></h1>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include_once "classic-multi.php" ?>
<div class="container">
    <hr/>
    <footer>
        <p>&copy; ZooParc de Beauval 2014</p>
    </footer>
</div>

<script src="/survey/js/apps/mois/multi.js"></script>
</body>
</html>

