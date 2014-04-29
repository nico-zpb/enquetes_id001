<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 26/04/2014
 * Time: 10:27
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
// mois de depart, jour 1
$dateStart = DateTime::createFromFormat("j-n-Y", "1-" . $monthStart . "-" . $annee);
// timestamp du premier jour du mois de depart
$dateStartTs = $dateStart->getTimestamp();

// obtention du nombre de jour du mois de fin
$dateEndDayOne = DateTime::createFromFormat("j-n-Y", "1-" . $monthEnd . "-" . $annee);
$lastDay = $dateEndDayOne->format("t");

// mois de fin, dernier jour
$dateEnd = DateTime::createFromFormat("j-n-Y", $lastDay . "-" . $monthEnd . "-" . $annee);
// timestamp du dernier jour du mois de fin
$dateEndTs = $dateEnd->getTimestamp();
// range($monthStart-1, $monthEnd-1)
$periodMoisList = array_slice($datas_mois, $monthStart - 1, $monthEnd - ($monthStart - 1));


/////////  tableau clients par mois ///////

$ClientsByMonth = [];
$numEntryByMonth = [];
$numEntriesTotal = 0;
$sql = "SELECT * FROM clients WHERE arrive_annee=:annee AND arrive_mois=:mois";
$stmt = $pdo->prepare($sql);
for ($i = $monthStart; $i < $monthEnd + 1; $i++) {

    $stmt->bindValue(":annee", $annee);
    $stmt->bindValue(":mois", $i);
    $stmt->execute();
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {
        $ClientsByMonth[$datas_mois[$i - 1]] = [];
        $numEntryByMonth[$datas_mois[$i - 1]] = 0;
    }
    $ClientsByMonth[$datas_mois[$i - 1]] = $result;
    $numEntryByMonth[$datas_mois[$i - 1]] = count($result);
    $numEntriesTotal += count($result);
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

foreach ($ClientsByMonth as $monthShortName => $clientsInMonth) {
    $connaissanceByMonth[$monthShortName] = getEmptyConnaissanceArr();
    $connaissanceNumByMonth[$monthShortName] = 0;

    foreach ($clientsInMonth as $k => $client) {
        $stmt->bindValue(":id", $client["id"]);
        $stmt->execute();
        $tmp = $stmt->fetchAll();
        if ($tmp) {
            foreach ($tmp as $l => $t) {
                $connaissanceByMonth[$monthShortName][$t["type_id"] - 1]++;
                $connaissanceTotal[$t["type_id"] - 1]++;
                $connaissanceEntries++;
            }
        }
    }

    for ($i = 0; $i < 11; $i++) {
        $connaissanceNumByMonth[$monthShortName] += $connaissanceByMonth[$monthShortName][$i];
    }

    $all = $connaissanceNumByMonth[$monthShortName];

    $connaissancePercentByMonth[$monthShortName] = array_map(function ($it) use ($all) {
        return round(($it / $all) * 100);
    }, $connaissanceByMonth[$monthShortName]);

}

$connaissancePercentTotal = array_map(function ($it) use ($connaissanceEntries) {
    return round(($it / $connaissanceEntries) * 100);
}, $connaissanceTotal);


//////////// regions d'habitation page-2

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

foreach ($ClientsByMonth as $m => $d) {

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
$numCentreByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100);
}, $numCentreByMonth, $totalByMonth);
$numParisByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100);
}, $numParisByMonth, $totalByMonth);
$numOtherByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100);
}, $numOtherByMonth, $totalByMonth);
$numEtrangerByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100);
}, $numEtrangerByMonth, $totalByMonth);

///////// connaissance par zone page-3
$connaissanceRegionCentreByMonth = [];
$connaissanceRegionCentreByMonthTotal = [];
$connaissanceRegionParisByMonth = [];
$connaissanceRegionParisByMonthTotal = [];
$connaissanceRegionAutresByMonth = [];
$connaissanceRegionAutresByMonthTotal = [];

$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
foreach($ClientsByMonth as $month=>$clients){

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
            if (in_array($c["departement_num"], $depsCentre)) {
                foreach($result as $key=>$type){
                    $connaissanceRegionCentreByMonthTotal[$month]++;
                    $connaissanceRegionCentreByMonth[$month][$type["type_id"] - 1]++;
                }
            } elseif (in_array($c["departement_num"], $depsParis)) {
                foreach($result as $key=>$type){
                    $connaissanceRegionParisByMonthTotal[$month]++;
                    $connaissanceRegionParisByMonth[$month][$type["type_id"] - 1]++;
                }
            } else {
                if ($c["departement_num"] != 100) {
                    foreach($result as $key=>$type){
                        $connaissanceRegionAutresByMonthTotal[$month]++;
                        $connaissanceRegionAutresByMonth[$month][$type["type_id"] - 1]++;
                    }
                }
            }
        }

    }
}

//////////// satisfaction globale page-4
$sql = "SELECT * FROM satisfaction WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$satisfactionByMonth = [];
$satisfactionByMonthTotal = [];
$totalSatisfaction = 0;
foreach($ClientsByMonth as $month=>$client){
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
            $satisfactionByMonth[$month]["prix"][(int)$r["prix"]-1]++;

            ////// spa
            $satisfactionByMonth[$month]["spa"][(int)$r["spa"]-1]++;

            //// revenir
            $satisfactionByMonth[$month]["revenir"][(int)$r["revenir"]-1]++;

            ///// recommander
            $satisfactionByMonth[$month]["recommander"][(int)$r["recommander"]-1]++;






        }
    }

}
////// le zoo

$sql = "SELECT visite_zoo FROM sejours WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$visiteZooByMonth = [];
$visiteZooTotalByMonth = [];
foreach($ClientsByMonth as $month=>$client){
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
        if($r){
            $visiteZooTotalByMonth[$month]++;
            $visiteZooByMonth[$month][(int)$r["visite_zoo"]-1]++;
        }
    }
}


?>
<script src="/survey/js/vendor/globalize.min.js"></script>
<script src="/survey/js/vendor/dx.chartjs.js"></script>
<script>
    <?php
        $datas = "";
        foreach($connaissancePercentByMonth as $month=>$d){
            $datas .= '{month:"'.$month.'", ';
            foreach($d as $k=>$v){
                $datas .= 'type'.$k.':'.$v.', ';
            }
            $datas = rtrim($datas, ", ");
            $datas .= '},';
        }
        $datas = rtrim($datas,", ");
        $series = "";
        foreach($connaissance_types as $k=>$v){
            $series .='{valueField:"type'.$k.'",name:"'.$v.'"},';
        }
        $series = rtrim($series,",");



     ?>
    var originConnaissanceHotel = {
        dataSource : [<?php echo $datas; ?>],
        commonSeriesSettings:{
            type: "bar",
            argumentField: "month"

        },
        series: [<?php echo $series; ?>],
        tooltip: {
            enabled: true,
            customizeText: function () {
                return this.valueText + "%";
            }
        }
    };
</script>


<?php
include_once "evolution/page-1.php";
include_once "evolution/page-2.php";
include_once "evolution/page-3.php";
include_once "evolution/page-4.php";
include_once "evolution/page-5.php";
include_once "evolution/page-6.php";
?>
