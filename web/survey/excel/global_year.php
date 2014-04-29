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
foreach($clientsByMonth as $month=>$clients){
    $connaissanceByMonthByType[$month] = getEmptyConnaissanceArr();

    foreach($clients as $key=>$client){
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
    }
    $connaissanceTotalByMonth[$month] = 0;
    for ($i = 0; $i < count($connaissanceTotalByType); $i++) {
        $connaissanceTotalByMonth[$month] += $connaissanceByMonthByType[$month][$i];
    }

    $all = $connaissanceTotalByMonth[$month];

    $connaissancePercentByMonthByType[$month] = array_map(function($it) use ($all){
        return round(($it / $all) * 100);
    }, $connaissanceByMonthByType[$month]);
}

//var_dump($connaissanceByMonthByType, $connaissanceTotalByType, $connaissanceTotal, $connaissanceTotalByMonth, $connaissancePercentByMonthByType);

$workbook = new PHPExcel();
PHPExcel_Settings::setLocale("fr_FR");
$workbook->getProperties()->setTitle("Les Jardins de Beauval");
$activeSheet = $workbook->getActiveSheet();
$activeSheet->setTitle("année " . $annee);

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
        "alignment"=>[
            "horizontal"=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        ],
    ]
);
$activeSheet->getColumnDimension("B")->setAutoSize(true);



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



$excelWriter = new PHPExcel_Writer_Excel2007($workbook);
$excelWriter->save($savePath . DIRECTORY_SEPARATOR . "test.xlsx");






























