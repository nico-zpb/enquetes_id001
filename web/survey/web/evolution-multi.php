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


//////////// regions d'habitation

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

?>




<?php
include_once "evolution/page-1.php";
include_once "evolution/page-2.php";

?>
