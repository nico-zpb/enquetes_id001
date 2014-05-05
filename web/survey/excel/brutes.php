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



$startRow = 2;
$endRow = $startRow;
foreach($allClients as $key=>$client){

    $sqlSejour = "SELECT * FROM sejours WHERE client_id=:id";
    $sejourStmt = $pdo->prepare($sqlSejour);
    $sejourStmt->bindValue(":id", $client["id"]);
    $sejourStmt->execute();
    $sejour = $sejourStmt->fetch();

    $activeSheet->getRowDimension($endRow)->setRowHeight(30);
    $endRow++;
    /// comment connu hotel
    $sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $client["id"]);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if($result){
        $connaissanceTypesStr = "/ ";
        foreach($result as $l=>$type){
            $connaissanceTypesStr .= $connaissance_types[$type["type_id"] - 1] . " / ";

            if($type["type_id"] == 11){
                $subSql = "SELECT * FROM connaissance_types_custom WHERE client_id=:id";
                $subStmt = $pdo->prepare($subSql);
                $subStmt->bindValue(":id", $client["id"]);
                $subStmt->execute();
                $subResult = $subStmt->fetchAll();
                if($subResult){
                    //var_dump($subResult[0]);
                    $activeSheet->setCellValueByColumnAndRow(1, $startRow+$key, $subResult[0]["name"]);
                }
            }
        }

        $activeSheet->setCellValueByColumnAndRow(0, $startRow+$key, $connaissanceTypesStr);

    }
    // departement numero
    if($client["departement_num"]){
        $activeSheet->setCellValueByColumnAndRow(2, $startRow+$key, $client["departement_num"]);
    }

    // pays etranger ?
    if((int)$client["departement_num"] == 100){
        $activeSheet->setCellValueByColumnAndRow(3, $startRow+$key, $client["pays"]);
    }

    // temps trajet
    if($client["tps_trajet"]){
        $activeSheet->setCellValueByColumnAndRow(4, $startRow+$key, $datas_tps_trajet[$client["tps_trajet"]-1]);
    }

    //type de chambre
    if($sejour && $sejour["type_chambre"]>0){
        $activeSheet->setCellValueByColumnAndRow(5, $startRow+$key, $datas_type_chambre[$sejour["type_chambre"]-1]);
    }

    //mois d'arrivee
    if($client["arrive_mois"]){
        $activeSheet->setCellValueByColumnAndRow(6, $startRow+$key, ucfirst($datas_mois[$client["arrive_mois"]-1]));
    }




}
$activeSheet->getStyle($columnNames[0].$startRow.":".$columnNames[$numCols].$endRow)->applyFromArray([
    "font"=>[
        "name"=>"Calibri",
        "size"=>11,
    ],
    "alignment"=>[
        "wrap"=>true,
        "vertical"=>PHPExcel_Style_Alignment::VERTICAL_TOP,
    ],
]);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// sauvegarde
$excelWriter = new PHPExcel_Writer_Excel2007($workbook);
$excelWriter->save($savePath . DIRECTORY_SEPARATOR . "donnees_brutes_" . $annee . ".xlsx");
