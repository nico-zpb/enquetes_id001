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
include_once LIBS . "/PHPExcel.php";
if (!isConnected()) {
    header("Location: /index.php");
    die();
}
if (!isPost() || !postExists("form_excel_global_mensuel")) {
    header("Location: /index.php");
    die();
}
$savePath = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "downloads";
$form = getPost("form_excel_global_mensuel");
$annee = (int)$form["annee"];

$monthStart = $form["month_start"];
$monthEnd = $form["month_end"];

$today = new DateTime("now");
$todayMonth = $today->format("n");

// erreur sur mois
$errorMsg = "";
if(!$debug){
    if($monthStart>$todayMonth){
        $errorMsg .= "Erreur : Le mois de début de période ne peut être supérieur au mois actuel. ";
    }
    if($monthEnd>$todayMonth){
        $errorMsg .= "Erreur : Le mois de fin de période ne peut être supérieur au mois actuel. ";
    }
    if($monthStart>$monthEnd){
        $errorMsg .= "Erreur : Le mois de début de période ne peut être supérieur au mois de fin de période. ";
    }
}
if($errorMsg){
    setFlash($errorMsg);
    header("Location: /survey/to-excel.php");
    die();
}
$numEntry = 0;
$effectifByMonth = [];
for($i = $monthStart; $i<$monthEnd+1; $i++){
    $sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee";
    $clientNumStmt = $pdo->prepare($sql);
    $clientNumStmt->bindValue(":arrive_mois", $i);
    $clientNumStmt->bindValue(":arrive_annee", $annee);
    $clientNumStmt->execute();
    $countClients = $clientNumStmt->fetch();
    $numEntry += $countClients["num"];
    $effectifByMonth[$datas_mois[$i-1]] = $countClients["num"];
}



if(!$numEntry){
    setFlash("Il n'y a pas de résultats sur la période demandée.");
    header("Location: /survey/to-excel.php");
    die();
}

$effectifByMonthPercent = array_map(function($it) use($numEntry){
    return round(($it/$numEntry) * 100, 1);
}, $effectifByMonth);
// timestamps
$dateStart = DateTime::createFromFormat("j-n-Y","1-".$monthStart."-".$annee);
$dateStartTs = $dateStart->getTimestamp();
// obtention du nombre de jour du mois de fin
$dateEndDayOne = DateTime::createFromFormat("j-n-Y","1-" . $monthEnd . "-" . $annee);
$lastDay = $dateEndDayOne->format("t");
// mois de fin, dernier jour
$dateEnd = DateTime::createFromFormat("j-n-Y",$lastDay . "-" . $monthEnd . "-" . $annee);
// timestamp du dernier jour du mois de fin
$dateEndTs = $dateEnd->getTimestamp();

$sql = "SELECT * FROM clients AS c LEFT JOIN satisfaction AS s WHERE c.arrive_annee=:annee AND c.arrive_mois=:mois AND c.id=s.client_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":annee", $annee);

$allClientsByMonth = [];
for($i = $monthStart; $i<$monthEnd+1; $i++){
    $stmt->bindValue(":mois", $i);
    $stmt->execute();
    $r = $stmt->fetchAll();
    if($r){
        //TODO a faire ???
    }
}




















