<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 29/04/14
 * Time: 12:38
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
if (!isPost() || !postExists("form_excel_brutes")) {
    header("Location: /index.php");
    die();
}
$savePath = realpath(dirname(__DIR__)) . DIRECTORY_SEPARATOR . "downloads";
$form = getPost("form_excel_brutes");
$annee = (int)$form["annee"];
$monthStart = 1;
$dateForTodayMonth = new DateTime();
$monthEnd = $dateForTodayMonth->format("n");
if ($debug) {
    $monthEnd = 12;
    if(file_exists($savePath . DIRECTORY_SEPARATOR . "donnees_brutes_" . $annee . ".xlsx")){
        if(!unlink($savePath . DIRECTORY_SEPARATOR . "donnees_brutes_" . $annee . ".xlsx")){
            die("fichier non supprimé");
        }
    }
}
include_once "../../../php/enquete-connexion.php";
$tmpDateStart = DateTime::createFromFormat("j-n-Y", "1-1-" . $annee);
$tmpDateStartTs = $tmpDateStart->getTimestamp();
$tmpLastDayVal = DateTime::createFromFormat("j-n-Y", "1-" . $monthEnd . "-" . $annee);
$tmpLastDay = $tmpLastDayVal->format("t");
$tmpDateEnd = DateTime::createFromFormat("j-n-Y", $tmpLastDay . "-" . $monthEnd . "-" . $annee);
$tmpDateEndTs = $tmpDateEnd->getTimestamp();
$sql = "SELECT * FROM clients WHERE arrive_timestamp>=:datestartts AND arrive_timestamp<=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $tmpDateStartTs);
$stmt->bindValue(":dateendts", $tmpDateEndTs);
$stmt->execute();
$allClients = $stmt->fetchAll();
if (!count($allClients)) {
    setFlash("Il n'y a pas de résultats sur la période demandée.");
    header("Location: /survey/to-excel.php");
    die();
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// column name
$alpha = range("A","Z");
$columnNames = $alpha;
foreach($alpha as $k=>$v){
    foreach($alpha as $l=>$w){
        $columnNames[] = $v.$w;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$workbook = new PHPExcel();
PHPExcel_Settings::setLocale("fr_FR");
$workbook->getProperties()->setTitle("Les Jardins de Beauval - Données brutes");

$activeSheet = $workbook->getActiveSheet();
$activeSheet->setTitle("année " . $annee);
$activeSheet->getSheetView()->setZoomScale(70);
$numCols = 0;
foreach($questions as $k=>$v){
    $activeSheet->setCellValueByColumnAndRow($k, 1, $v);
    $activeSheet->getColumnDimensionByColumn($k)->setWidth(15);
    $numCols++;
}
$activeSheet->getRowDimension(1)->setRowHeight(30);
$activeSheet->setAutoFilter($activeSheet->calculateWorksheetDimension());
$activeSheet->getStyle($columnNames[0]."1:".$columnNames[$numCols]."1")->applyFromArray([
    "font"=>[
        "bold"=>true,
        "name"=>"Arial",
        "size"=>10,
    ],
    "alignment"=>[
        "wrap"=>true,
        "vertical"=>PHPExcel_Style_Alignment::VERTICAL_TOP,
    ]
]);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// sauvegarde
$excelWriter = new PHPExcel_Writer_Excel2007($workbook);
$excelWriter->save($savePath . DIRECTORY_SEPARATOR . "donnees_brutes_" . $annee . ".xlsx");
