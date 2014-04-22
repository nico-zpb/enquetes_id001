<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 22/04/14
 * Time: 14:15
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

include_once "../../../php/functions.php";


if(!isPost() && !isAjax() || !postExists("form_excel_range") ){
    header("Location: /index.php");
    die();
}

include_once "../../../php/enquete-connexion.php";


$formDatas = getPost("form_excel_range");

$dateTimeZone = new DateTimeZone("Europe/Paris");
$today = new DateTime('now', $dateTimeZone);
$todayTs = $today->getTimestamp();

/// date de debut
$jourStart = $formDatas["jour_start"];
$moisStart = $formDatas["mois_start"];
$anneeStart = $formDatas["annee_start"];
$dateStart = DateTime::createFromFormat("j-n-Y",$jourStart . "-" . $moisStart . "-" . $anneeStart, $dateTimeZone);
$dateStartTimestamp = $dateStart->getTimestamp();

if($dateStartTimestamp >= $todayTs){
    header("Content-Type: appliaction/json");
    echo json_encode(["link"=>"", "error"=>true, "errorMsg"=>"Vous avez séléctionnez une date de début de recherche supérieure ou égale à la date d'aujourd'hui."]);
    die();
}


/// date de fin
$jourEnd = $formDatas["jour_end"];
$moisEnd = $formDatas["mois_end"];
$anneeEnd = $formDatas["annee_end"];
$dateEnd = DateTime::createFromFormat("j-n-Y", $jourEnd . "-" . $moisEnd . "-" . $anneeEnd , $dateTimeZone);
$dateEndTimestamp = $dateEnd->getTimestamp();

if($dateEndTimestamp >= $todayTs){
    $dateEndTimestamp = $todayTs;
}



$sql = "SELECT * FROM clients WHERE arrive_timestamp >= :datestarttimestamp AND arrive_timestamp <= :dateendtimestamp";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestarttimestamp", $dateStartTimestamp);
$stmt->bindValue(":dateendtimestamp", $dateEndTimestamp);
$stmt->execute();
$resultClientsPeriode = $stmt->fetchAll();

$sql = "SELECT * FROM sejours WHERE arrive_timestamp >= :datestarttimestamp AND arrive_timestamp <= :dateendtimestamp";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestarttimestamp", $dateStartTimestamp);
$stmt->bindValue(":dateendtimestamp", $dateEndTimestamp);
$stmt->execute();
$resultSejoursPeriode = $stmt->fetchAll();


var_dump($resultClientsPeriode); die();


header("Content-Type: appliaction/json");
//echo json_encode(["link"=>"", "error"=>true, "errorMsg"=>"Une erreur est survenue. Désolé pour ce désagrément."]);
echo json_encode(["link"=>"/survey/downloads/balbal.zip", "error"=>false,]);
die();