<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 08:54
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
include_once "../../../../datas/all.php";
include_once "../../../../php/functions.php";

if(!isConnected()){
    header("Location: /index.php");
    die();
}

if(!isPost() || !postExists("form_pdfe_range")){
    header("Location: /index.php");
    die();
}


$form = getPost("form_pdfe_range");

$annee = (int)$form["annee"];
$monthStart = 1;
$dateStart = DateTime::createFromFormat("j-n-Y", "1-".$monthStart."-".$annee);

// aujourd'hui
$dateForToday = new DateTime();
// mois actuel
$monthEnd = $dateForToday->format("n");

if($debug){
    $monthEnd = 12;
}


$tmpDateEnd = DateTime::createFromFormat("j-n-Y", "1-" . $monthEnd . "-" . $annee);
// nombre de jours dans le mois actuel
$lastDayOfMonthEnd = $tmpDateEnd->format("t");
// datetime du dernier jour du mois actuel
$dateEnd = DateTime::createFromFormat("j-n-Y", $lastDayOfMonthEnd . "-" . $monthEnd . "-" .$annee);

// recup des timestamps
$dateStartTs = $dateStart->getTimestamp();
$dateEndTs = $dateEnd->getTimestamp();


$numEntry = 0;
include_once "../../../../php/enquete-connexion.php";

// verif il y a t-il des enregistrements pour la periode ?
$sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_timestamp>=:datestartts AND arrive_timestamp<=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $dateStartTs);
$stmt->bindValue(":dateendts", $dateEndTs);
$stmt->execute();
$numEntry = $stmt->fetch()["num"];

if(!$numEntry){
    setFlash("Il n'y a pas de résultats sur la période demandée.");
    header("Location: /survey/to-pdf.php");
    die();
}

$clientsByMonth = [];
$numEntryByMonth = [];
$numEntriesTotal = 0;

$sql = "SELECT * FROM clients WHERE arrive_annee=:annee AND arrive_mois=:mois";
$stmt = $pdo->prepare($sql);
for ($i = $monthStart; $i < $monthEnd + 1; $i++) {

    $stmt->bindValue(":annee", $annee);
    $stmt->bindValue(":mois", $i);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {
        $clientsByMonth[$datas_mois[$i - 1]] = [];
        $numEntryByMonth[$datas_mois[$i - 1]] = 0;
    }
    $count = count($result);
    $clientsByMonth[$datas_mois[$i - 1]] = $result;
    $numEntryByMonth[$datas_mois[$i - 1]] = $count;
    $numEntriesTotal += $count;
}

/////////// connaissance /////////
function getEmptyConnaissanceArr()
{
    return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
}

$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);

$connaissanceByMonth = [];
$connaissanceNumByMonth = [];
$connaissancePercentByMonth = [];
$connaissanceTotal = getEmptyConnaissanceArr();
$connaissanceEntries = 0;

foreach ($clientsByMonth as $monthShortName => $clientsInMonth) {
    $connaissanceByMonth[$monthShortName] = getEmptyConnaissanceArr();
    $connaissanceNumByMonth[$monthShortName] = 0;

    foreach ($clientsInMonth as $k => $client) {
        $stmt->bindValue(":id", $client["id"]);
        $stmt->execute();
        $tmp = $stmt->fetchAll();
        if ($tmp) {
            foreach ($tmp as $l => $t) {
                if($t["type_id"]>0){
                    $connaissanceByMonth[$monthShortName][$t["type_id"] - 1]++;
                    $connaissanceTotal[$t["type_id"] - 1]++;
                    $connaissanceEntries++;
                }
            }
        }
    }

    for ($i = 0; $i < count($connaissanceTotal); $i++) {
        $connaissanceNumByMonth[$monthShortName] += $connaissanceByMonth[$monthShortName][$i];
    }

    $all = $connaissanceNumByMonth[$monthShortName];

    $connaissancePercentByMonth[$monthShortName] = array_map(function ($it) use ($all) {
        if($all>0){
            return round(($it / $all) * 100);
        } else {
            return 0;
        }

    }, $connaissanceByMonth[$monthShortName]);

}

$connaissancePercentTotal = array_map(function ($it) use ($connaissanceEntries) {
    if($connaissanceEntries>0){
        return round(($it / $connaissanceEntries) * 100);
    } else {
        return 0;
    }

}, $connaissanceTotal);


//////////// regions d'habitation page_07

$numCentreByMonth = [];
$numParisByMonth = [];
$numOtherByMonth = [];
$numEtrangerByMonth = [];
$totalByMonth = [];
$totalCentre = 0;
$totalParis = 0;
$totalOther = 0;
$totalEtranger = 0;
$totalOriginEntry = 0;

foreach ($clientsByMonth as $m => $d) {

    if (empty($numCentreByMonth[$m])) {
        $numCentreByMonth[$m] = 0;
    }
    if (empty($numParisByMonth[$m])) {
        $numParisByMonth[$m] = 0;
    }
    if (empty($numOtherByMonth[$m])) {
        $numOtherByMonth[$m] = 0;
    }
    if (empty($numEtrangerByMonth[$m])) {
        $numEtrangerByMonth[$m] = 0;
    }
    if (empty($totalByMonth[$m])) {
        $totalByMonth[$m] = 0;
    }

    foreach ($d as $k => $c) {
        $totalOriginEntry++;
        if (in_array($c["departement_num"], $depsCentre)) {
            $numCentreByMonth[$m]++;
            $totalCentre++;
        } elseif (in_array($c["departement_num"], $depsParis)) {
            $numParisByMonth[$m]++;
            $totalParis++;
        } else {
            if ($c["departement_num"] != 100) {
                $numOtherByMonth[$m]++;
                $totalOther++;
            } else {
                $numEtrangerByMonth[$m]++;
                $totalEtranger++;
            }
        }
        $totalByMonth[$m]++;
    }


}
$numCentreByMonthPercent= array_map(function ($it, $to) {
    if($to>0){
        return round(($it / $to) * 100,1);
    } else {
        return 0;
    }

}, $numCentreByMonth, $totalByMonth);

$numParisByMonthPercent = array_map(function ($it, $to) {
    if($to>0){
        return round(($it / $to) * 100,1);
    } else {
        return 0;
    }

}, $numParisByMonth, $totalByMonth);

$numOtherByMonthPercent = array_map(function ($it, $to) {
    if($to>0){
        return round(($it / $to) * 100,1);
    } else {
        return 0;
    }
}, $numOtherByMonth, $totalByMonth);

$numEtrangerByMonthPercent = array_map(function ($it, $to) {
    if($to>0){
        return round(($it / $to) * 100,1);
    } else {
        return 0;
    }
}, $numEtrangerByMonth, $totalByMonth);


///////// connaissance par zone page_09
$connaissanceRegionCentreByMonth = [];
$connaissanceRegionCentreByMonthTotal = [];
$connaissanceRegionParisByMonth = [];
$connaissanceRegionParisByMonthTotal = [];
$connaissanceRegionAutresByMonth = [];
$connaissanceRegionAutresByMonthTotal = [];
$connaissanceToutConfonduByMonth = [];
$connaissanceToutConfonduByMonthTotal = [];


$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
foreach($clientsByMonth as $month=>$clients){
    if(empty($connaissanceToutConfonduByMonth[$month])){
        $connaissanceToutConfonduByMonth[$month] = getEmptyConnaissanceArr();
    }
    if(empty($connaissanceToutConfonduByMonthTotal[$month])){
        $connaissanceToutConfonduByMonthTotal[$month] = 0;
    }

    if(empty($connaissanceRegionCentreByMonth[$month])){
        $connaissanceRegionCentreByMonth[$month] = getEmptyConnaissanceArr();
    }
    if(empty($connaissanceRegionParisByMonth[$month])){
        $connaissanceRegionParisByMonth[$month] = getEmptyConnaissanceArr();
    }
    if(empty($connaissanceRegionAutresByMonth[$month])){
        $connaissanceRegionAutresByMonth[$month] = getEmptyConnaissanceArr();
    }
    if(empty($connaissanceRegionCentreByMonthTotal[$month])){
        $connaissanceRegionCentreByMonthTotal[$month] = 0;
    }
    if(empty($connaissanceRegionParisByMonthTotal[$month])){
        $connaissanceRegionParisByMonthTotal[$month] = 0;
    }
    if(empty($connaissanceRegionAutresByMonthTotal[$month])){
        $connaissanceRegionAutresByMonthTotal[$month] = 0;
    }



    foreach($clients as $k=>$c){
        $stmt->bindValue(":id", $c["id"]);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if($result){
            foreach($result as $key=>$type){
                if($type["type_id"]>0){
                    $connaissanceToutConfonduByMonth[$month][$type["type_id"] - 1]++;
                    $connaissanceToutConfonduByMonthTotal[$month]++;
                }
            }
            if (in_array($c["departement_num"], $depsCentre)) {
                foreach($result as $key=>$type){
                    if($type["type_id"]>0){
                        $connaissanceRegionCentreByMonthTotal[$month]++;
                        $connaissanceRegionCentreByMonth[$month][$type["type_id"] - 1]++;
                    }
                }
            } elseif (in_array($c["departement_num"], $depsParis)) {
                foreach($result as $key=>$type){
                    if($type["type_id"]>0){
                        $connaissanceRegionParisByMonthTotal[$month]++;
                        $connaissanceRegionParisByMonth[$month][$type["type_id"] - 1]++;
                    }
                }
            } else {
                if ($c["departement_num"] != 100) {
                    foreach($result as $key=>$type){
                        if($type["type_id"]>0){
                            $connaissanceRegionAutresByMonthTotal[$month]++;
                            $connaissanceRegionAutresByMonth[$month][$type["type_id"] - 1]++;
                        }
                    }
                }
            }
        }

    }
}

//////////// satisfaction globale page_10 page_11
$sql = "SELECT * FROM satisfaction WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$satisfactionByMonth = [];
$satisfactionByMonthTotal = [];
$totalSatisfaction = 0;
foreach($clientsByMonth as $month=>$client){
    if(empty($satisfactionByMonth[$month])){
        $satisfactionByMonth[$month] = [];
    }
    if(empty($satisfactionByMonthTotal[$month])){
        $satisfactionByMonthTotal[$month] = 0;
    }
    if(empty($satisfactionByMonth[$month]["globalement"])){
        $satisfactionByMonth[$month]["globalement"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["chambres"])){
        $satisfactionByMonth[$month]["chambres"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["restauration"])){
        $satisfactionByMonth[$month]["restauration"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["bar"])){
        $satisfactionByMonth[$month]["bar"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["accueil"])){
        $satisfactionByMonth[$month]["accueil"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["environnement"])){
        $satisfactionByMonth[$month]["environnement"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["rapport"])){
        $satisfactionByMonth[$month]["rapport"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["resto_amabilite"])){
        $satisfactionByMonth[$month]["resto_amabilite"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["resto_service"])){
        $satisfactionByMonth[$month]["resto_service"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["resto_diversite"])){
        $satisfactionByMonth[$month]["resto_diversite"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["resto_plats"])){
        $satisfactionByMonth[$month]["resto_plats"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["resto_vins"])){
        $satisfactionByMonth[$month]["resto_vins"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["resto_prix"])){
        $satisfactionByMonth[$month]["resto_prix"] = [0,0];
    }
    if(empty($satisfactionByMonth[$month]["spa"])){
        $satisfactionByMonth[$month]["spa"] = [0,0,0,0];
    }
    if(empty($satisfactionByMonth[$month]["revenir"])){
        $satisfactionByMonth[$month]["revenir"] = [0,0,0,0];
    }
    if(empty($satisfactionByMonth[$month]["recommander"])){
        $satisfactionByMonth[$month]["recommander"] = [0,0,0,0];
    }
    if(empty($satisfactionByMonth[$month]["prix"])){
        $satisfactionByMonth[$month]["prix"] = [0,0,0];
    }



    foreach($client as $k=>$c){
        $stmt->bindValue(":id", $c["id"]);
        $stmt->execute();
        $r = $stmt->fetch();

        if($r){
            $satisfactionByMonthTotal[$month]++;
            $totalSatisfaction++;
            /////////////// globale
            if((int)$r["globalement"] === 1){
                $satisfactionByMonth[$month]["globalement"][0]++;
            }
            if((int)$r["globalement"] === 2){
                $satisfactionByMonth[$month]["globalement"][1]++;
            }
            if((int)$r["chambres"] === 1){
                $satisfactionByMonth[$month]["chambres"][0]++;
            }
            if((int)$r["chambres"] === 2){
                $satisfactionByMonth[$month]["chambres"][1]++;
            }
            if((int)$r["restauration"] === 1){
                $satisfactionByMonth[$month]["restauration"][0]++;
            }
            if((int)$r["restauration"] === 2){
                $satisfactionByMonth[$month]["restauration"][1]++;
            }
            if((int)$r["bar"] === 1){
                $satisfactionByMonth[$month]["bar"][0]++;
            }
            if((int)$r["bar"] === 2){
                $satisfactionByMonth[$month]["bar"][1]++;
            }
            if((int)$r["accueil"] === 1){
                $satisfactionByMonth[$month]["accueil"][0]++;
            }
            if((int)$r["accueil"] === 2){
                $satisfactionByMonth[$month]["accueil"][1]++;
            }
            if((int)$r["environnement"] === 1){
                $satisfactionByMonth[$month]["environnement"][0]++;
            }
            if((int)$r["environnement"] === 2){
                $satisfactionByMonth[$month]["environnement"][1]++;
            }
            if((int)$r["rapport"] === 1){
                $satisfactionByMonth[$month]["rapport"][0]++;
            }
            if((int)$r["rapport"] === 2){
                $satisfactionByMonth[$month]["rapport"][1]++;
            }

            //////////// resto
            if((int)$r["resto_amabilite"] === 1){
                $satisfactionByMonth[$month]["resto_amabilite"][0]++;
            }
            if((int)$r["resto_amabilite"] === 2){
                $satisfactionByMonth[$month]["resto_amabilite"][1]++;
            }
            if((int)$r["resto_service"] === 1){
                $satisfactionByMonth[$month]["resto_service"][0]++;
            }
            if((int)$r["resto_service"] === 2){
                $satisfactionByMonth[$month]["resto_service"][1]++;
            }
            if((int)$r["resto_diversite"] === 1){
                $satisfactionByMonth[$month]["resto_diversite"][0]++;
            }
            if((int)$r["resto_diversite"] === 2){
                $satisfactionByMonth[$month]["resto_diversite"][1]++;
            }
            if((int)$r["resto_plats"] === 1){
                $satisfactionByMonth[$month]["resto_plats"][0]++;
            }
            if((int)$r["resto_plats"] === 2){
                $satisfactionByMonth[$month]["resto_plats"][1]++;
            }
            if((int)$r["resto_vins"] === 1){
                $satisfactionByMonth[$month]["resto_vins"][0]++;
            }
            if((int)$r["resto_vins"] === 2){
                $satisfactionByMonth[$month]["resto_vins"][1]++;
            }
            if((int)$r["resto_prix"] === 1){
                $satisfactionByMonth[$month]["resto_prix"][0]++;
            }
            if((int)$r["resto_prix"] === 2){
                $satisfactionByMonth[$month]["resto_prix"][1]++;
            }
            ///// perception prix
            if($r["prix"]>0){
                $satisfactionByMonth[$month]["prix"][(int)$r["prix"]-1]++;
            }
            ////// spa
            if($r["spa"]>0){
                $satisfactionByMonth[$month]["spa"][(int)$r["spa"]-1]++;
            }
            //// revenir
            if($r["revenir"]>0){
                $satisfactionByMonth[$month]["revenir"][(int)$r["revenir"]-1]++;
            }
            ///// recommander
            if($r["recommander"]>0){
                $satisfactionByMonth[$month]["recommander"][(int)$r["recommander"]-1]++;
            }
        }
    }
}

////// le zoo

$sql = "SELECT visite_zoo FROM sejours WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$visiteZooByMonth = [];
$visiteZooTotalByMonth = [];
foreach($clientsByMonth as $month=>$client){
    if(empty($visiteZooByMonth[$month])){
        $visiteZooByMonth[$month] = [0,0];
    }
    if(empty($visiteZooTotalByMonth[$month])){
        $visiteZooTotalByMonth[$month] = 0;
    }

    foreach($client as $k=>$c){
        $stmt->bindValue(":id", $c["id"]);
        $stmt->execute();
        $r = $stmt->fetch();
        if($r && $r["visite_zoo"]>0){
            $visiteZooTotalByMonth[$month]++;
            $visiteZooByMonth[$month][(int)$r["visite_zoo"]-1]++;
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//charts

include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pData.class.php");
include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pDraw.class.php");
include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pPie.class.php");
include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pImage.class.php");

$baseDir = realpath(__DIR__);
$points = [];
$values = array_values($connaissanceToutConfonduByMonth);
$numTypes = count($values[0]);
for($i=0;$i<$numTypes;$i++){
    $points[] = [];
}

$datas = new pData();

foreach($connaissanceToutConfonduByMonth as $month=>$typeArray){
    foreach($typeArray as $k=>$v){
        $percent = 0;
        if($connaissanceToutConfonduByMonthTotal[$month]>0){
            $percent = round(($v/$connaissanceToutConfonduByMonthTotal[$month])*100,1);
        }

        $points[$k][] = $percent;
    }
}

foreach($points as $k=>$point){
    $datas->addPoints($point, $connaissance_types_small[$k]);
}


$datas->addPoints($datas_mois, "mois");
$datas->setAbscissa("mois");
$picture = new pImage(1000,350,$datas);
$picture->setGraphArea(20,35,980,320);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_LEFTRIGHT, "Mode"=>SCALE_MODE_ADDALL]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawLegend(20,20,["Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER,"FontSize"=>8]);
$picture->drawBarChart(["DisplayOrientation"=>ORIENTATION_HORIZONTAL,"Interleave"=>1.5]);
$picture->render($baseDir ."/img/connaissance_total_evolution.png");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$points = [];
$values = array_values($connaissanceRegionParisByMonth);
$numTypes = count($values[0]);
for($i=0;$i<$numTypes;$i++){
    $points[] = [];
}

$datas = new pData();
foreach($connaissanceRegionParisByMonth as $month=>$typeArray){
    foreach($typeArray as $k=>$v){
        $percent = 0;
        if($connaissanceRegionParisByMonthTotal[$month]>0){
            $percent = round(($v/$connaissanceRegionParisByMonthTotal[$month])*100,1);
        }

        $points[$k][] = $percent;
    }
}

foreach($points as $k=>$point){
    $datas->addPoints($point, $connaissance_types_small[$k]);
}

$datas->addPoints($datas_mois, "mois");
$datas->setAbscissa("mois");
$picture = new pImage(1000,500,$datas);
$picture->setGraphArea(20,20,980,480);

$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawText(70, 70, "Région Parisienne",["FontSize"=>20,"R"=>"0","G"=>"0","B"=>"0"]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_LEFTRIGHT, "Mode"=>SCALE_MODE_ADDALL]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawLegend(20,20,["Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER,"FontSize"=>8]);
$picture->drawBarChart(["DisplayOrientation"=>ORIENTATION_HORIZONTAL,"Interleave"=>1.5]);
$picture->render($baseDir ."/img/connaissance_paris_evolution.png");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$points = [];
$values = array_values($connaissanceRegionCentreByMonth);
$numTypes = count($values[0]);
for($i=0;$i<$numTypes;$i++){
    $points[] = [];
}

$datas = new pData();
foreach($connaissanceRegionCentreByMonth as $month=>$typeArray){
    foreach($typeArray as $k=>$v){
        $percent = 0;
        if($connaissanceRegionCentreByMonthTotal[$month]>0){
            $percent = round(($v/$connaissanceRegionCentreByMonthTotal[$month])*100,1);
        }

        $points[$k][] = $percent;
    }
}

foreach($points as $k=>$point){
    $datas->addPoints($point, $connaissance_types_small[$k]);
}

$datas->addPoints($datas_mois, "mois");
$datas->setAbscissa("mois");
$picture = new pImage(1000,500,$datas);
$picture->setGraphArea(20,20,980,480);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawText(70, 70, "Région Centre",["FontSize"=>20,"R"=>"0","G"=>"0","B"=>"0"]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_LEFTRIGHT, "Mode"=>SCALE_MODE_ADDALL]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawLegend(20,20,["Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER,"FontSize"=>8]);
$picture->drawBarChart(["DisplayOrientation"=>ORIENTATION_HORIZONTAL,"Interleave"=>1.5]);
$picture->render($baseDir ."/img/connaissance_centre_evolution.png");


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$points = [];
$values = array_values($connaissanceRegionAutresByMonth);
$numTypes = count($values[0]);
for($i=0;$i<$numTypes;$i++){
    $points[] = [];
}

$datas = new pData();
foreach($connaissanceRegionAutresByMonth as $month=>$typeArray){
    foreach($typeArray as $k=>$v){
        if($connaissanceRegionAutresByMonthTotal[$month]>0){
            $percent = round(($v/$connaissanceRegionAutresByMonthTotal[$month])*100,1);
        } else {
            $percent = 0;
        }

        $points[$k][] = $percent;
    }
}

foreach($points as $k=>$point){
    $datas->addPoints($point, $connaissance_types_small[$k]);
}

$datas->addPoints($datas_mois, "mois");
$datas->setAbscissa("mois");
$picture = new pImage(1000,500,$datas);
$picture->setGraphArea(20,20,980,480);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawText(70, 70, "Autres départements",["FontSize"=>20,"R"=>"0","G"=>"0","B"=>"0"]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_LEFTRIGHT, "Mode"=>SCALE_MODE_ADDALL]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawLegend(20,20,["Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER,"FontSize"=>8]);
$picture->drawBarChart(["DisplayOrientation"=>ORIENTATION_HORIZONTAL,"Interleave"=>1.5]);
$picture->render($baseDir ."/img/connaissance_autre_evolution.png");



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once(LIBS . DIRECTORY_SEPARATOR . "html2pdf.class.php");




ob_start();
    include(dirname(__FILE__) . "/page_01.php");
    include(dirname(__FILE__) . "/page_02.php"); /* sommaire */
    include(dirname(__FILE__) . "/page_03.php"); /* nombre de questionnaires */
    //include(dirname(__FILE__)."/page_04.php"); /* page de commentataires */
    include(dirname(__FILE__) . "/page_05.php");
    include(dirname(__FILE__) . "/page_06.php"); /* mensuel - general - origine de la connaissance de l'hotel */
    include(dirname(__FILE__) . "/page_07.php"); /* region d'habitation zone d'attraction */
    include(dirname(__FILE__) . "/page_08.php"); /* mensuel - zone - charts - origine de la connaissance de l'hotel */
    include(dirname(__FILE__) . "/page_09.php"); /* mensuel - zone - origine de la connaissance de l'hotel */
    include(dirname(__FILE__) . "/page_10.php"); /* mensuel - zone - origine de la connaissance de l'hotel */
    include(dirname(__FILE__) . "/page_11.php"); /* mensuel - zone - origine de la connaissance de l'hotel */
    include(dirname(__FILE__) . "/page_12.php"); /* mensuel - zone - Perception du rapport qualité/prix de l'hôtel */
    include(dirname(__FILE__) . "/page_13.php"); /* mensuel - zone - Satisfaction concernant le SPA */
    include(dirname(__FILE__) . "/page_14.php"); /* mensuel - zone - visite zoo */
    include(dirname(__FILE__) . "/page_15.php"); /* mensuel - zone - revenir */
    include(dirname(__FILE__) . "/page_16.php"); /* mensuel - zone - recommander */
$content = ob_get_clean();

try{
    $converter = new HTML2PDF('L','A4','fr',true,'UTF-8',[0,0,0,0]);
    $converter->pdf->SetDisplayMode('fullpage');
    $converter->writeHTML($content, false);
    $converter->createIndex('', null, 15, false, true, 2);
    $converter->Output('about.pdf');

} catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
