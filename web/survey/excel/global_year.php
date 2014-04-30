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
include_once LIBS."/PHPExcel.php";

if(!isConnected()){
    header("Location: /index.php");
    die();
}

if(!isPost() || !postExists("form_excel_global")){
    header("Location: /index.php");
    die();
}

$savePath = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "downloads";

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
$effectifsByMonth = [];
$effectifTotal = 0;

for($i=$monthStart; $i<$monthEnd+1; $i++){


    $stmt->bindValue(":mois", $i);
    $stmt->execute();

    $r = $stmt->fetchAll();
    if($r){
        $clientsByMonth[$datas_mois[$i-1]] = $r;
        $count = count($r);
        $effectifsByMonth[$datas_mois[$i-1]] = $count;
        $effectifTotal += $count;
    } else {
        $clientsByMonth[$datas_mois[$i-1]] = [];
        $effectifsByMonth[$datas_mois[$i-1]] = 0;
    }
}

$percentByMonth = array_map(function($it) use($effectifTotal){
    return round(($it/$effectifTotal) * 100);
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
foreach($clientsByDeptsByMonth as $num=>$name){
    $clientsByDeptsByMonth[$num] = [];
    foreach($datas_mois as $mois){
        $clientsByDeptsByMonth[$num][$mois] = 0;
    }
}




foreach($clientsByMonth as $month=>$clients){
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



    foreach($clients as $key=>$client){
        //// connaissance de d l'hôtel global/mois
        $stmt->bindValue(":id", $client["id"]);
        $stmt->execute();
        $r= $stmt->fetchAll();

        if($r){
            foreach($r as $k=>$v){
                $connaissanceByMonthByType[$month][$v["type_id"] - 1]++;
                $connaissanceTotalByType[$v["type_id"] - 1]++;
                $connaissanceTotal++;
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

    $connaissancePercentByMonthByType[$month] = array_map(function($it) use ($all){
        return round(($it / $all) * 100);
    }, $connaissanceByMonthByType[$month]);
        
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
$numAllDeptsByMonthPercent = [];
foreach($clientsByDeptsByMonth as $k=>$v){
    //$k=>num dep, $v=>tableau effectif/mois
    if(empty($numAllDeptsByMonthPercent[$k])){
        $numAllDeptsByMonthPercent[$k] = [];
    }
    foreach($v as $m=>$e){
        $numAllDeptsByMonthPercent[$k][$m] = round(($clientsByDeptsByMonth[$k][$m] / $totalByMonth[$m]) * 100) . "%";
    }
}






$workbook = new PHPExcel();
PHPExcel_Settings::setLocale("fr_FR");
$workbook->getProperties()->setTitle("Les Jardins de Beauval");
$columnNames = range("A", "Z");
$activeSheet = $workbook->getActiveSheet();
$activeSheet->setTitle("année " . $annee);
$activeSheet->getColumnDimension("B")->setAutoSize(true);
/// tableau des effectifs



$activeSheet->getStyle('C7:D7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle('C7:D7')->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle('B7:D20')->applyFromArray(
    [
        "borders"=>[
            "allborders"=>[
                "style"=>PHPExcel_Style_Border::BORDER_THIN,
                "color"=>[
                    "rgb"=>"000000"
                ]
            ]
        ],
    ]
);
$activeSheet->getStyle('C7:D20')->applyFromArray(
    [
        "alignment"=>[
            "horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);



$activeSheet->setCellValue('B7', 'Mois');
$activeSheet->setCellValue('C7', 'Effectifs');
$activeSheet->setCellValue('D7', '%');
$start = 8;
foreach($effectifsByMonth as $month=>$effectif){
    $activeSheet->setCellValueByColumnAndRow(1, $start, $month);
    $activeSheet->setCellValueByColumnAndRow(2, $start, $effectif);
    $activeSheet->setCellValueByColumnAndRow(3, $start, "$percentByMonth[$month]%");
    $start++;
}
$activeSheet->setCellValueByColumnAndRow(1, $start, "Total");
$activeSheet->setCellValueByColumnAndRow(2, $start, $effectifTotal);
$activeSheet->setCellValueByColumnAndRow(3, $start, "100%");

//// connaissance globale


$activeSheet->getStyle('C25:N25')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle('C25:N25')->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle('B25:N36')->applyFromArray(
    [
        "borders"=>[
            "allborders"=>[
                "style"=>PHPExcel_Style_Border::BORDER_THIN,
                "color"=>[
                    "rgb"=>"000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle('C25:N36')->applyFromArray(
    [
        "alignment"=>[
            "horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);




$activeSheet->setCellValue('B25', ' ');
for($i=0; $i<count($monthes); $i++){
    $activeSheet->setCellValueByColumnAndRow(2+$i, 25, $monthes[$i]);
}
$start = 26;
foreach($connaissance_types as $key=>$type){

    $activeSheet->setCellValueByColumnAndRow(1, $start, $type);
    $startCol = 2;
    foreach($monthes as $l=>$month){
        $activeSheet->setCellValueByColumnAndRow($startCol, $start, $connaissancePercentByMonthByType[$month][$key]."%");
        $startCol++;
    }
    $start++;
}

//// repartition par region
$activeSheet->getStyle('C41:N41')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle('C41:N41')->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle('B41:N45')->applyFromArray(
    [
        "borders"=>[
            "allborders"=>[
                "style"=>PHPExcel_Style_Border::BORDER_THIN,
                "color"=>[
                    "rgb"=>"000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle('C41:N45')->applyFromArray(
    [
        "alignment"=>[
            "horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);

$start = 2;
foreach($monthes as $k=>$v){
    $activeSheet->setCellValueByColumnAndRow($start+$k, 41, $v);

    $activeSheet->setCellValueByColumnAndRow($start+$k, 45, $totalByMonth[$v]);

}
$activeSheet->setCellValueByColumnAndRow(1, 42, "Région Centre");
$activeSheet->setCellValueByColumnAndRow(1, 43, "Région Parisienne");
$activeSheet->setCellValueByColumnAndRow(1, 44, "Autres Départements");
$activeSheet->setCellValueByColumnAndRow(1, 45, "Total");


foreach($numCentreByMonthPercent as $k=>$v){
    $activeSheet->setCellValueByColumnAndRow($start+$k, 42, "$v%");
}
foreach($numParisByMonthPercent as $k=>$v){
    $activeSheet->setCellValueByColumnAndRow($start+$k, 43, "$v%");
}
foreach($numOtherByMonthPercent as $k=>$v){
    $activeSheet->setCellValueByColumnAndRow($start+$k, 44, "$v%");
}


//// repartition par departement




$startCol = 2;
$startRow = 51;
foreach($monthes as $k=>$v){
    $activeSheet->setCellValueByColumnAndRow($start+$k, $startRow-1, $v);
}

$counter = 0;
foreach($numAllDeptsByMonthPercent as $dep=>$mois){
    $activeSheet->setCellValueByColumnAndRow($startCol-1, $startRow+$counter, $dep . " - " . $departements[$dep]);
    $monthCounter = 0;
    foreach($mois as $k=>$v){
        $activeSheet->setCellValueByColumnAndRow($start+$monthCounter, $startRow+$counter, $numAllDeptsByMonthPercent[$dep][$k]);
        $monthCounter++;
    }

    $counter++;
}
$activeSheet->getStyle($columnNames[$startCol].($startRow-1).":".$columnNames[$startCol+$monthCounter-1].($startRow-1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$activeSheet->getStyle($columnNames[$startCol].($startRow-1).":".$columnNames[$startCol+$monthCounter-1].($startRow-1))->getFill()->getStartColor()->setRGB('ffff00');
$activeSheet->getStyle($columnNames[$startCol-1].($startRow-1).":".$columnNames[$startCol+$monthCounter-1].($startRow+$counter-1))->applyFromArray(
    [
        "borders"=>[
            "allborders"=>[
                "style"=>PHPExcel_Style_Border::BORDER_THIN,
                "color"=>[
                    "rgb"=>"000000"
                ]
            ]
        ]
    ]
);
$activeSheet->getStyle($columnNames[$startCol].($startRow-1).":".$columnNames[$startCol+$monthCounter-1].($startRow+$counter-1))->applyFromArray(
    [
        "alignment"=>[
            "horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);




/// sauvegarde
$excelWriter = new PHPExcel_Writer_Excel2007($workbook);
$excelWriter->save($savePath . DIRECTORY_SEPARATOR . "test.xlsx");






























