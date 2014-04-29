<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 29/04/14
 * Time: 12:49
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

if(!isPost() || !postExists("form_excel_global")){
    header("Location: /index.php");
    die();
}

$form = getPost("form_excel_global");
$annee = (int)$form["annee"];
$monthStart = 1;

$dateForTodayMonth = new DateTime();
$monthEnd = $dateForTodayMonth->format("n");

if($debug){
    $monthEnd = 12;
}

include_once "../../../php/enquete-connexion.php";
// verif enregistrements pour la periode.
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
    header("Location: /survey/to-excel.php");
    die();
}


// effectifs par mois en nombre et pourcentage
// effectif total de la periode

$sql = "SELECT * FROM clients WHERE arrive_mois=:mois AND arrive_annee=:annee";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":annee", (int)$annee);
$clientsByMonth = [];

for($i=$monthStart; $i<$monthEnd+1; $i++){
    $clientsByMonth[$datas_mois[$i-1]] = [];

    $stmt->bindValue(":mois", $i);
    $stmt->execute();

    $r = $stmt->fetchAll();
    if($r){}
}
