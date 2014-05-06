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
$sql = "SELECT * FROM clients AS c LEFT JOIN satisfaction AS s WHERE c.arrive_timestamp>=:datestartts AND c.arrive_timestamp<=:dateendts AND c.id=s.client_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $tmpDateStartTs);
$stmt->bindValue(":dateendts", $tmpDateEndTs);
$stmt->execute();
$allClients = $stmt->fetchAll();
$stmt = null;
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
$sql = "SELECT * FROM sejours WHERE arrive_timestamp>=:datestartts AND arrive_timestamp<=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $tmpDateStartTs);
$stmt->bindValue(":dateendts", $tmpDateEndTs);
$stmt->execute();
$sejourAll = $stmt->fetchAll();
$stmt = null;



$startRow = 2;
$endRow = $startRow;
foreach($allClients as $key=>$client){

    $sejour = [];
    foreach($sejourAll as $k=>$val){
        if($val["client_id"] == $client["id"]){
            $sejour = $val;
            break;
        }
    }

    $activeSheet->getRowDimension($endRow)->setRowHeight(30);
    $endRow++;
    /// comment connu hotel
    $sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", $client["id"]);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $stmt = null;
    if($result){
        $connaissanceTypesStr = "/ ";
        foreach($result as $l=>$type){
            $connaissanceTypesStr .= $connaissance_types[$type["type_id"] - 1] . " / ";

            if($type["type_id"] == 11){
                $sql = "SELECT * FROM connaissance_types_custom WHERE client_id=:id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id", $client["id"]);
                $stmt->execute();
                $subResult = $stmt->fetchAll();
                $stmt = null;
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

    //nbre nuits
    if($sejour && $sejour["nbre_nuit"]>0){
        $activeSheet->setCellValueByColumnAndRow(7, $startRow+$key, $sejour["nbre_nuit"]);
    }

    //nbre personnes adultes
    if($sejour && $sejour["nbre_adulte"]>0){
        $activeSheet->setCellValueByColumnAndRow(8, $startRow+$key, $datas_nbr_personnes[$sejour["nbre_adulte"]-1]);
    }

    //nbre personnes enfants
    if($sejour && $sejour["nbre_enfant"]>0){
        $activeSheet->setCellValueByColumnAndRow(9, $startRow+$key, $datas_nbr_personnes[$sejour["nbre_enfant"]-1]);
    }

    // satisfaction global
    if($client["globalement"]){
        $activeSheet->setCellValueByColumnAndRow(10, $startRow+$key, $datas_satisfaction_bis[$client["globalement"]-1]);
    }

    // prix approprie
    if($client["prix"]){
        $activeSheet->setCellValueByColumnAndRow(11, $startRow+$key, $datas_perception_prix[$client["prix"]-1]);
    }

    // satisfaction chambres
    if($client["chambres"]){
        $activeSheet->setCellValueByColumnAndRow(12, $startRow+$key, $datas_satisfaction_bis[$client["chambres"]-1]);
    }

    // satisfaction restauration
    if($client["restauration"]){
        $activeSheet->setCellValueByColumnAndRow(13, $startRow+$key, $datas_satisfaction_bis[$client["restauration"]-1]);
    }

    // satisfaction bar
    if($client["bar"]){
        $activeSheet->setCellValueByColumnAndRow(14, $startRow+$key, $datas_satisfaction_bis[$client["bar"]-1]);
    }

    // satisfaction accueil
    if($client["accueil"]){
        $activeSheet->setCellValueByColumnAndRow(15, $startRow+$key, $datas_satisfaction_bis[$client["accueil"]-1]);
    }

    // satisfaction environnement
    if($client["environnement"]){
        $activeSheet->setCellValueByColumnAndRow(16, $startRow+$key, $datas_satisfaction_bis[$client["environnement"]-1]);
    }

    // satisfaction rapport
    if($client["rapport"]){
        $activeSheet->setCellValueByColumnAndRow(17, $startRow+$key, $datas_satisfaction_bis[$client["rapport"]-1]);
    }

    // satisfaction resto_amabilite
    if($client["resto_amabilite"]){
        $activeSheet->setCellValueByColumnAndRow(18, $startRow+$key, $datas_satisfaction_bis[$client["resto_amabilite"]-1]);
    }

    // satisfaction resto_service
    if($client["resto_service"]){
        $activeSheet->setCellValueByColumnAndRow(19, $startRow+$key, $datas_satisfaction_bis[$client["resto_service"]-1]);
    }

    // satisfaction resto_diversite
    if($client["resto_diversite"]){
        $activeSheet->setCellValueByColumnAndRow(20, $startRow+$key, $datas_satisfaction_bis[$client["resto_diversite"]-1]);
    }

    // satisfaction resto_plats
    if($client["resto_plats"]){
        $activeSheet->setCellValueByColumnAndRow(21, $startRow+$key, $datas_satisfaction_bis[$client["resto_plats"]-1]);
    }

    // satisfaction resto_vins
    if($client["resto_vins"]){
        $activeSheet->setCellValueByColumnAndRow(22, $startRow+$key, $datas_satisfaction_bis[$client["resto_vins"]-1]);
    }

    // satisfaction resto_prix
    if($client["resto_prix"]){
        $activeSheet->setCellValueByColumnAndRow(23, $startRow+$key, $datas_satisfaction_bis[$client["resto_prix"]-1]);
    }

    // satisfaction spa
    if($client["spa"]){
        $activeSheet->setCellValueByColumnAndRow(24, $startRow+$key, $datas_satisfaction_bis[$client["spa"]-1]);
    }

    // sejour wifi
    if($sejour && $sejour["wifi"]>0){
        $activeSheet->setCellValueByColumnAndRow(25, $startRow+$key, $datas_wifi[$sejour["wifi"]-1]);
    }

    //sejour visite_zoo
    if($sejour && $sejour["visite_zoo"]>0){
        $visite = ($sejour["visite_zoo"] == 1) ? "Oui" : "Non";
        $activeSheet->setCellValueByColumnAndRow(26, $startRow+$key, $visite);
    }

    // satisfaction revenir
    if($client["revenir"]){
        $activeSheet->setCellValueByColumnAndRow(27, $startRow+$key, $datas_intentions[$client["revenir"]-1]);
    }

    // satisfaction recommander
    if($client["recommander"]){
        $activeSheet->setCellValueByColumnAndRow(28, $startRow+$key, $datas_intentions[$client["recommander"]-1]);
    }

    // commentaire
    if($client["commentaire"]){
        $activeSheet->setCellValueByColumnAndRow(29, $startRow+$key, $client["commentaire"]);
    }

    // genre
    $sexe = "";
    if($client["sexe"]){
        $sexe = ($client["sexe"] == 1) ? "Homme": "Femme";
        $activeSheet->setCellValueByColumnAndRow(30, $startRow+$key, $sexe);
    }

    // age
    if($client["tranche_age"]){
        $activeSheet->setCellValueByColumnAndRow(31, $startRow+$key, $datas_trancheAge[$client["tranche_age"]-1]["name"]);
    }

    //prof
    if($client["profession"]){
        $activeSheet->setCellValueByColumnAndRow(32, $startRow+$key, $profession[$client["profession"]-1]);
    }

    // recevoir infos
    if($client["infos"]){
        $info = ((int)$client["infos"] === 1)? "Oui": "Non";
        $activeSheet->setCellValueByColumnAndRow(33, $startRow+$key, $info);
    }

    //civilite
    if($sexe){
        $civilite = ($sexe == "Homme")? "Mr": "Mme";
        $activeSheet->setCellValueByColumnAndRow(34, $startRow+$key, $civilite);
    }

    // nom
    if($client["nom"]){
        $activeSheet->setCellValueByColumnAndRow(35, $startRow+$key, $client["nom"]);
    }

    // prenom
    if($client["prenom"]){
        $activeSheet->setCellValueByColumnAndRow(36, $startRow+$key, $client["prenom"]);
    }

    // email
    if($client["email"]){
        $activeSheet->setCellValueByColumnAndRow(37, $startRow+$key, $client["email"]);
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
