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

if (!isPost() || !postExists("form_excel_global")) {
    header("Location: /index.php");
    die();
}

$savePath = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "downloads";

$form = getPost("form_excel_global");
$annee = (int)$form["annee"];
$monthStart = 1;

$dateForTodayMonth = new DateTime();
$monthEnd = $dateForTodayMonth->format("n");

if ($debug) {
    $monthEnd = 12;
    if(file_exists($savePath . DIRECTORY_SEPARATOR . "evolution_mensuelle_" . $annee . ".xlsx")){
        if(!unlink($savePath . DIRECTORY_SEPARATOR . "evolution_mensuelle_" . $annee . ".xlsx")){
            die("fichier non supprimé");
        }
    }
}

include_once "../../../php/enquete-connexion.php";
// verif enregistrements pour la periode.
$tmpDateStart = DateTime::createFromFormat("j-n-Y", "1-1-" . $annee);
$tmpDateStartTs = $tmpDateStart->getTimestamp();
$tmpLastDayVal = DateTime::createFromFormat("j-n-Y", "1-" . $monthEnd . "-" . $annee);
$tmpLastDay = $tmpLastDayVal->format("t");
$tmpDateEnd = DateTime::createFromFormat("j-n-Y", $tmpLastDay . "-" . $monthEnd . "-" . $annee);
$tmpDateEndTs = $tmpDateEnd->getTimestamp();
$sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_timestamp>=:datestartts AND arrive_timestamp<=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $tmpDateStartTs);
$stmt->bindValue(":dateendts", $tmpDateEndTs);
$stmt->execute();
$numEntry = $stmt->fetch()["num"];
if (!$numEntry) {
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
$effectifsByMonth = [];
$effectifTotal = 0;

for ($i = $monthStart; $i < $monthEnd + 1; $i++) {


    $stmt->bindValue(":mois", $i);
    $stmt->execute();

    $r = $stmt->fetchAll();
    if ($r) {
        $clientsByMonth[$datas_mois[$i - 1]] = $r;
        $count = count($r);
        $effectifsByMonth[$datas_mois[$i - 1]] = $count;
        $effectifTotal += $count;
    } else {
        $clientsByMonth[$datas_mois[$i - 1]] = [];
        $effectifsByMonth[$datas_mois[$i - 1]] = 0;
    }
}

$percentByMonth = array_map(function ($it) use ($effectifTotal) {
    return round(($it / $effectifTotal) * 100);
}, $effectifsByMonth);


//// connaissance de d l'hôtel global/mois
function getEmptyConnaissanceArr()
{
    return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
}

$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$connaissanceByMonthByType = [];
$connaissanceTotalByType = getEmptyConnaissanceArr();
$connaissanceTotal = 0;
$connaissanceTotalByMonth = [];
$connaissancePercentByMonthByType = [];
$monthes = [];

//// repartition par region
$numCentreByMonth = [];
$numParisByMonth = [];
$numOtherByMonth = [];
$numEtrangerByMonth = [];
$totalCentre = 0;
$totalParis = 0;
$totalOther = 0;
$totalEtranger = 0;
$totalOriginEntry = 0;

/// par departements
$clientsByDeptsByMonth = $departements;
foreach ($clientsByDeptsByMonth as $num => $name) {
    $clientsByDeptsByMonth[$num] = [];
    foreach ($datas_mois as $mois) {
        $clientsByDeptsByMonth[$num][$mois] = 0;
    }
}

///////// connaissance par zone
$connaissanceRegionCentreByMonthByType = [];
$connaissanceRegionCentreByMonthTotal = [];
$connaissanceRegionParisByMonthByType = [];
$connaissanceRegionParisByMonthTotal = [];
$connaissanceRegionAutresByMonthByType = [];
$connaissanceRegionAutresByMonthTotal = [];


foreach ($clientsByMonth as $month => $clients) {
    $monthes[] = $month;


    $connaissanceByMonthByType[$month] = getEmptyConnaissanceArr();

    if (empty($numCentreByMonth[$month])) {
        $numCentreByMonth[$month] = 0;
    }
    if (empty($numParisByMonth[$month])) {
        $numParisByMonth[$month] = 0;
    }
    if (empty($numOtherByMonth[$month])) {
        $numOtherByMonth[$month] = 0;
    }
    if (empty($numEtrangerByMonth[$month])) {
        $numEtrangerByMonth[$month] = 0;
    }
    if (empty($totalByMonth[$month])) {
        $totalByMonth[$month] = 0;
    }

    if(empty($connaissanceRegionCentreByMonth[$month])){
        $connaissanceRegionCentreByMonthByType[$month] = getEmptyConnaissanceArr();
    }
    if(empty($connaissanceRegionParisByMonth[$month])){
        $connaissanceRegionParisByMonthByType[$month] = getEmptyConnaissanceArr();
    }
    if(empty($connaissanceRegionAutresByMonth[$month])){
        $connaissanceRegionAutresByMonthByType[$month] = getEmptyConnaissanceArr();
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


    foreach ($clients as $key => $client) {
        //// connaissance de d l'hôtel global/mois
        $stmt->bindValue(":id", $client["id"]);
        $stmt->execute();
        $r = $stmt->fetchAll();

        //// connaissance de d l'hôtel par zone/mois
        if ($r) {
            foreach ($r as $k => $v) {
                $connaissanceByMonthByType[$month][$v["type_id"] - 1]++;
                $connaissanceTotalByType[$v["type_id"] - 1]++;
                $connaissanceTotal++;
            }

            if (in_array($client["departement_num"], $depsCentre)) {
                foreach($r as $l=>$type){
                    $connaissanceRegionCentreByMonthTotal[$month]++;
                    $connaissanceRegionCentreByMonthByType[$month][$type["type_id"] - 1]++;
                }
            } elseif (in_array($client["departement_num"], $depsParis)) {
                foreach($r as $l=>$type){
                    $connaissanceRegionParisByMonthTotal[$month]++;
                    $connaissanceRegionParisByMonthByType[$month][$type["type_id"] - 1]++;
                }
            } else {
                if ($client["departement_num"] != 100) {
                    foreach($r as $l=>$type){
                        $connaissanceRegionAutresByMonthTotal[$month]++;
                        $connaissanceRegionAutresByMonthByType[$month][$type["type_id"] - 1]++;
                    }
                }
            }
        }
        //// repartition par region
        $totalOriginEntry++;
        if (in_array($client["departement_num"], $depsCentre)) {
            $numCentreByMonth[$month]++;
            $totalCentre++;
        } elseif (in_array($client["departement_num"], $depsParis)) {
            $numParisByMonth[$month]++;
            $totalParis++;
        } else {
            if ($client["departement_num"] != 100) {
                $numOtherByMonth[$month]++;
                $totalOther++;
            } else {
                $numEtrangerByMonth[$month]++;
                $totalEtranger++;
            }
        }


        $totalByMonth[$month]++;

        /// par departement
        $clientsByDeptsByMonth[$client["departement_num"]][$month]++;
    }

    //// connaissance de d l'hôtel global/mois
    $connaissanceTotalByMonth[$month] = 0;
    for ($i = 0; $i < count($connaissanceTotalByType); $i++) {
        $connaissanceTotalByMonth[$month] += $connaissanceByMonthByType[$month][$i];
    }

    $all = $connaissanceTotalByMonth[$month];

    $connaissancePercentByMonthByType[$month] = array_map(function ($it) use ($all) {
        return round(($it / $all) * 100);
    }, $connaissanceByMonthByType[$month]);

}


$numCentreByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100, 1);
}, $numCentreByMonth, $totalByMonth);
$numParisByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100, 1);
}, $numParisByMonth, $totalByMonth);
$numOtherByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100, 1);
}, $numOtherByMonth, $totalByMonth);
$numEtrangerByMonthPercent = array_map(function ($it, $to) {
    return round(($it / $to) * 100, 1);
}, $numEtrangerByMonth, $totalByMonth);
$numAllDeptsByMonthPercent = [];
foreach ($clientsByDeptsByMonth as $k => $v) {
    //$k=>num dep, $v=>tableau effectif/mois
    if (empty($numAllDeptsByMonthPercent[$k])) {
        $numAllDeptsByMonthPercent[$k] = [];
    }
    foreach ($v as $m => $e) {
        $numAllDeptsByMonthPercent[$k][$m] = round(($clientsByDeptsByMonth[$k][$m] / $totalByMonth[$m]) * 100, 1) . "%";
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sql = "SELECT * FROM satisfaction WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$satisfactionByMonth = [];
$satisfactionByMonthTotal = [];
$totalSatisfaction = 0;
$satisfactionByMonthPrixTotalEffectif = [];
$satisfactionByMonthSpaTotalEffectif = [];
$satisfactionByMonthRevenirTotalEffectif = [];
$satisfactionByMonthRecommanderTotalEffectif = [];

foreach($clientsByMonth as $month=>$clients){
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




    foreach($clients as $key=>$client){
        $stmt->bindValue(":id", $client["id"]);
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
            if(empty($satisfactionByMonthPrixTotalEffectif[$month])){
                $satisfactionByMonthPrixTotalEffectif[$month] = 0;
            }
            if($r["prix"] > 0){
                $satisfactionByMonth[$month]["prix"][(int)$r["prix"]-1]++;

                $satisfactionByMonthPrixTotalEffectif[$month]++;
            }
            ////// spa
            if(empty($satisfactionByMonthSpaTotalEffectif[$month])){
                $satisfactionByMonthSpaTotalEffectif[$month] = 0;
            }
            if($r["spa"] > 0){
                $satisfactionByMonth[$month]["spa"][(int)$r["spa"]-1]++;

                $satisfactionByMonthSpaTotalEffectif[$month]++;
            }
            //// revenir
            if(empty($satisfactionByMonthRevenirTotalEffectif[$month])){
                $satisfactionByMonthRevenirTotalEffectif[$month] = 0;
            }
            if($r["revenir"] > 0){
                $satisfactionByMonth[$month]["revenir"][(int)$r["revenir"]-1]++;

                $satisfactionByMonthRevenirTotalEffectif[$month]++;
            }
            ///// recommander
            if(empty($satisfactionByMonthRecommanderTotalEffectif[$month])){
                $satisfactionByMonthRecommanderTotalEffectif[$month] = 0;
            }

            if($r["recommander"] > 0){
                $satisfactionByMonth[$month]["recommander"][(int)$r["recommander"]-1]++;
            }
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$workbook = new PHPExcel();
PHPExcel_Settings::setLocale("fr_FR");
$workbook->getProperties()->setTitle("Les Jardins de Beauval");
$columnNames = range("A", "Z");
$activeSheet = $workbook->getActiveSheet();
$activeSheet->setTitle("année " . $annee);
$activeSheet->getColumnDimension("B")->setAutoSize(true);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$activeSheet->getStyle('B2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle('B2')->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->setCellValueByColumnAndRow(1,2, "Résultats année " .$annee);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// tableau des effectifs


$activeSheet->getStyle('C7:D7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle('C7:D7')->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle('B7:D20')->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ],
    ]
);
$activeSheet->getStyle('C7:D20')->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

$activeSheet->getStyle("B4")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,4, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,5, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");

$activeSheet->setCellValue('B7', 'Mois');
$activeSheet->setCellValue('C7', 'Effectifs');
$activeSheet->setCellValue('D7', '%');
$start = 8;
foreach ($effectifsByMonth as $month => $effectif) {
    $activeSheet->setCellValueByColumnAndRow(1, $start, $month);
    $activeSheet->setCellValueByColumnAndRow(2, $start, $effectif);
    $activeSheet->setCellValueByColumnAndRow(3, $start, "$percentByMonth[$month]%");
    $start++;
}
$activeSheet->setCellValueByColumnAndRow(1, $start, "Total");
$activeSheet->setCellValueByColumnAndRow(2, $start, $effectifTotal);
$activeSheet->setCellValueByColumnAndRow(3, $start, "100%");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// connaissance globale


//TODO total

$activeSheet->getStyle("B24")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,24, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,25, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");
$activeSheet->setCellValueByColumnAndRow(1,26, "Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...");


$startRow = 28;
for ($i = 0; $i < count($monthes); $i++) {
    $activeSheet->setCellValueByColumnAndRow(2 + $i, $startRow, $monthes[$i]);
}
$activeSheet->setCellValueByColumnAndRow(2 + $i, $startRow, "Total");

$startRow += 1;
$startCol = 1;
$endRow = $startRow;
foreach ($connaissance_types as $key => $type) {

    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow + $key, $type);

    foreach ($monthes as $l => $month) {
        $activeSheet->setCellValueByColumnAndRow($startCol + $l + 1, $startRow + $key, $connaissancePercentByMonthByType[$month][$key] . "%");

    }
    $endRow++;
}


$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$startCol + 2 + 11] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$startCol + 2 + 11] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$startCol + 2 + 11] . ($endRow - 1))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$startCol + 2 + 11] . ($endRow - 1))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// repartition par region


//TODO total


$startRow = $endRow + 7;
$endRow = $startRow;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-4))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-4, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "Merci de noter le numéro de votre département d'habitation (2 chiffres; 100 pour pays étranger) :");


foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k + 1;
}
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow += 1;

$activeSheet->setCellValueByColumnAndRow(1, $startRow, "Région Centre");
$activeSheet->setCellValueByColumnAndRow(1, $startRow + 1, "Région Parisienne");
$activeSheet->setCellValueByColumnAndRow(1, $startRow + 2, "Autres Départements");
$activeSheet->setCellValueByColumnAndRow(1, $startRow + 3, "Total");


foreach ($numCentreByMonthPercent as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, "$v%");
}
foreach ($numParisByMonthPercent as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow + 1, "$v%");
}
foreach ($numOtherByMonthPercent as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow + 2, "$v%");
}
foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow + 3, $totalByMonth[$v]);
}
$endRow = $startRow + 3;

$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// repartition par departement


//TODO total


$startCol = 1;
$startRow = $endRow + 7;

$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-4))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-4, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "Merci de noter le numéro de votre département d'habitation (2 chiffres; 100 pour pays étranger) :");


foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}
$endCol += 1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow += 1;
$endRow = $startRow;
$counter = 0;
foreach ($numAllDeptsByMonthPercent as $dep => $mois) {
    $activeSheet->setCellValueByColumnAndRow($startCol, $endRow, $dep . " - " . $departements[$dep]);
    $monthCounter = 0;
    foreach ($mois as $k => $v) {
        $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $monthCounter, $endRow, $numAllDeptsByMonthPercent[$dep][$k]);
        $monthCounter++;
    }

    $endRow++;
}
$endRow -= 1;
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// connaissance region paris // $connaissanceRegionParisByMonthByType

//TODO descriptif
//TODO total
$startRow = $endRow + 7;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-4))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-4, "Filtre: Région Parisienne, Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;

foreach($connaissance_types as $key=>$type){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow + $key, $type);

    foreach ($monthes as $k => $v) {
        $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow + $key, round(($connaissanceRegionParisByMonthByType[$v][$key]/$connaissanceRegionParisByMonthTotal[$v])*100,1)."%" );

    }
    $endRow++;
}
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// connaissance region centre
//

//TODO descriptif
//TODO total
$startRow = $endRow + 7;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-4))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-4, "Filtre: Région Centre, Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;

foreach($connaissance_types as $key=>$type){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow + $key, $type);

    foreach ($monthes as $k => $v) {
        $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow + $key, round(($connaissanceRegionCentreByMonthByType[$v][$key]/$connaissanceRegionCentreByMonthTotal[$v])*100,1)."%" );

    }
    $endRow++;
}
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// connaissance region autres

//TODO total

$startRow = $endRow + 7;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-4))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-4, "Filtre: Autres départements, Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;

foreach($connaissance_types as $key=>$type){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow + $key, $type);

    foreach ($monthes as $k => $v) {
        $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow + $key, round(($connaissanceRegionAutresByMonthByType[$v][$key]/$connaissanceRegionAutresByMonthTotal[$v])*100,1)."%" );

    }
    $endRow++;
}
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// satisfaction globale

// satisfaits + tres satisfaits
$startRow = $endRow + 6;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-3))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "% de Très satisfaits + Satisfaits");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;

foreach($datas_services_bis as $k=>$service){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow+$k, $service);
}

foreach($monthes as $k => $v){
    $result = round( ( ( $satisfactionByMonth[$v]["globalement"][0] + $satisfactionByMonth[$v]["globalement"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["chambres"][0] + $satisfactionByMonth[$v]["chambres"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+1, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["restauration"][0] + $satisfactionByMonth[$v]["restauration"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+2, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["bar"][0] + $satisfactionByMonth[$v]["bar"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+3, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["accueil"][0] + $satisfactionByMonth[$v]["accueil"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+4, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["environnement"][0] + $satisfactionByMonth[$v]["environnement"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+5, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["rapport"][0] + $satisfactionByMonth[$v]["rapport"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+6, $result."%");

}

$endRow +=7;
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

//tres satisfaits

$startRow = $endRow + 6;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-3))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "% de Très satisfaits");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;


foreach($datas_services_bis as $k=>$service){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow+$k, $service);
}
foreach($monthes as $k => $v){
    $result = round( ( $satisfactionByMonth[$v]["globalement"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow, $result."%");

    $result = round( ( $satisfactionByMonth[$v]["chambres"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+1, $result."%");

    $result = round( ( $satisfactionByMonth[$v]["restauration"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+2, $result."%");

    $result = round( ( $satisfactionByMonth[$v]["bar"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+3, $result."%");

    $result = round( ( $satisfactionByMonth[$v]["accueil"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+4, $result."%");

    $result = round( ( $satisfactionByMonth[$v]["environnement"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+5, $result."%");

    $result = round( ( $satisfactionByMonth[$v]["rapport"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+6, $result."%");

}
$endRow +=7;
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// satisfaction hotel

// satisfaits + tres satisfaits
$startRow = $endRow + 6;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-3))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "% de Très satisfaits + Satisfaits");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;

foreach($datas_resto as $k=>$service){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow+$k, $service);
}

foreach($monthes as $k => $v){
    $result = round( ( ( $satisfactionByMonth[$v]["resto_amabilite"][0] + $satisfactionByMonth[$v]["resto_amabilite"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["resto_service"][0] + $satisfactionByMonth[$v]["resto_service"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+1, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["resto_diversite"][0] + $satisfactionByMonth[$v]["resto_diversite"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+2, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["resto_plats"][0] + $satisfactionByMonth[$v]["resto_plats"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+3, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["resto_vins"][0] + $satisfactionByMonth[$v]["resto_vins"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+4, $result."%");

    $result = round( ( ( $satisfactionByMonth[$v]["resto_prix"][0] + $satisfactionByMonth[$v]["resto_prix"][1] ) /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+5, $result."%");

}

$endRow +=6;
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);
//tres satisfaits
$startRow = $endRow + 6;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-3))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "% de Très satisfaits");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;

foreach($datas_resto as $k=>$service){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow+$k, $service);
}

foreach($monthes as $k => $v){
    $result = round( ( $satisfactionByMonth[$v]["resto_amabilite"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow, $result."%");

    $result = round( ( $satisfactionByMonth[$v]["resto_service"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+1, $result."%");

    $result = round( (  $satisfactionByMonth[$v]["resto_diversite"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+2, $result."%");

    $result = round( (  $satisfactionByMonth[$v]["resto_plats"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+3, $result."%");

    $result = round( (  $satisfactionByMonth[$v]["resto_vins"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+4, $result."%");

    $result = round( (  $satisfactionByMonth[$v]["resto_prix"][0] /  $satisfactionByMonthTotal[$v]) * 100 , 1);
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+5, $result."%");

}

$endRow +=6;
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// prix
$startRow = $endRow + 6;
$endRow = $startRow;
$startCol = 1;
$endCol = $startCol;

$activeSheet->getStyle("B".($startRow-4))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
$activeSheet->setCellValueByColumnAndRow(1,$startRow-4, "Filtre: Cumul depuis le début de l'année.");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-3, "Merci d'indiquer votre date d'arrivée à l'hôtel (saisir le mois ci-dessous)");
$activeSheet->setCellValueByColumnAndRow(1,$startRow-2, "Au regard de la qualité des chambres et de l'environnement de l'hôtel, avez-vous trouvé le prix :");

foreach ($monthes as $k => $v) {
    $activeSheet->setCellValueByColumnAndRow($startCol + 1 + $k, $startRow, $v);
    $endCol = $startCol + 1 + $k;
}

$endCol+=1;
$activeSheet->setCellValueByColumnAndRow($endCol, $startRow, "Total");
$startRow +=1;

foreach($datas_perception_prix as $k=>$prix){
    $activeSheet->setCellValueByColumnAndRow($startCol, $startRow+$k, $prix);
    $endRow += 1;
}
$endRow += 1;
$activeSheet->setCellValueByColumnAndRow($startCol, $endRow, "Total");

foreach($monthes as $k=>$v){
    if($satisfactionByMonthPrixTotalEffectif[$v] == 0){
        continue;
    }
    foreach($satisfactionByMonth[$v]["prix"] as $perc=>$num){
        $result = round(($num / $satisfactionByMonthPrixTotalEffectif[$v]) * 100, 1);
        $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $startRow+$perc, $result."%");

    }
    $activeSheet->setCellValueByColumnAndRow($startCol+1+$k, $endRow, $satisfactionByMonthPrixTotalEffectif[$v]);
}
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($startRow - 1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "borders" => [
            "allborders" => [
                "style" => PHPExcel_Style_Border::BORDER_THIN,
                "color" => [
                    "rgb" => "000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol + 1] . ($startRow - 1) . ":" . $columnNames[$endCol] . ($endRow))->applyFromArray(
    [
        "alignment" => [
            "horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// spa


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// visite zoo


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// revenir


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// recommander



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// sauvegarde

$excelWriter = new PHPExcel_Writer_Excel2007($workbook);
$excelWriter->save($savePath . DIRECTORY_SEPARATOR . "evolution_mensuelle_" . $annee . ".xlsx");






























