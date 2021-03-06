<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 19/05/14
 * Time: 15:31
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

if(!isPost() || !postExists("form_pdfa_range")){
    header("Location: /index.php");
    die();
}
$form = getPost("form_pdfa_range");

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
$sql = "SELECT * FROM clients WHERE arrive_timestamp>=:datestartts AND arrive_timestamp<=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $dateStartTs);
$stmt->bindValue(":dateendts", $dateEndTs);
$stmt->execute();
$clients = $stmt->fetchAll();

if(!$clients){
    setFlash("Il n'y a pas de résultats sur la période demandée.");
    header("Location: /survey/to-pdf.php");
    die();
}
$numEntry = count($clients);
$numMale = 0;
$numFemale = 0;
$tranchesAgeCount=[];
$profCount = [];
foreach($datas_trancheAge as $k=>$v){
    $tranchesAgeCount[$k] = 0;
}
foreach($datas_professions as $k=>$v){
    $profCount[$k] = 0;
}
$tranchesAge = [];
$prof = [];
$max = 0;
$highlightAge = null;
$maxProf = 0;
$highlightProf = null;
foreach($clients as $k=>$client){
    if($client["sexe"] == 1){
        $numMale++;
    }
    if( $client["sexe"]== 2){
        $numFemale++;
    }
    if($client["tranche_age"]>0){
        $tranchesAgeCount[$client["tranche_age"]-1]++;
    }
    if($client["profession"]>0){
        $profCount[$client["profession"]-1]++;
    }
}

$numMalePercent = round(($numMale / $numEntry) * 100);
$numFemalePercent = round(($numFemale / $numEntry) * 100);
foreach($tranchesAgeCount as $k=>$v){
    if($v>$max){
        $max = $v;
        $highlightAge = $k;
    }
    $tranchesAge[] = ["name" => $datas_trancheAge[$k]["name"], "num" => $v, "percent" => round(($v / $numEntry) * 100,1)];
}
foreach($profCount as $k=>$v){
    if($v>$maxProf){
        $maxProf = $v;
        $highlightProf = $k;
    }
    $prof[] = ["name" => $datas_professions[$k]["name"], "num" => $v, "percent" => round(($v / $numEntry) * 100,1)];
}

// satisfaction
$sql = "SELECT * FROM satisfaction WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$satisfaction = [];
foreach ($clients as $k => $c) {
    $stmt->bindValue(":id", $c["id"]);
    $stmt->execute();
    $result = $stmt->fetch();
    if($result){
        $satisfaction[] = $result;
    }
}
/////////////////////////////
/////////////////////////////
$toPercent = function ($it) use ($numEntry) {
    if($numEntry>0){
        return round(($it / $numEntry) * 100,1);
    } else {
        return 0;
    }

};

// satisfaction globale
$globalSatisf = [0, 0, 0, 0];
$satifChambre = [0, 0, 0, 0];
$satifRestauration = [0, 0, 0, 0];
$satifBar = [0, 0, 0, 0];
$satifAccueil = [0, 0, 0, 0];
$satifEnvironement = [0, 0, 0, 0];
$satifRapport = [0, 0, 0, 0];
$perceptionPrix = [0, 0, 0];
$satifAmabilite = [0, 0, 0, 0];
$satifService = [0, 0, 0, 0];
$satifDiversite = [0, 0, 0, 0];
$satifPlats = [0, 0, 0, 0];
$satifVins = [0, 0, 0, 0];
$satifPrix = [0, 0, 0, 0];
$revenir = [0, 0, 0, 0,];
$recommander = [0, 0, 0, 0];

foreach ($satisfaction as $k => $v) {

    if($v["globalement"] > 0){
        $globalSatisf[$v["globalement"] - 1]++;
    }
    if($v["chambres"] > 0){
        $satifChambre[$v["chambres"] - 1]++;
    }
    if($v["restauration"] > 0){
        $satifRestauration[$v["restauration"] - 1]++;
    }
    if($v["bar"] > 0){
        $satifBar[$v["bar"] - 1]++;
    }
    if($v["accueil"] > 0){
        $satifAccueil[$v["accueil"] - 1]++;
    }
    if($v["environnement"] > 0){
        $satifEnvironement[$v["environnement"] - 1]++;
    }
    if($v["rapport"] > 0){
        $satifRapport[$v["rapport"] - 1]++;
    }
    if($v["prix"] > 0){
        $perceptionPrix[$v["prix"] - 1]++;
    }
    if($v["resto_amabilite"] > 0){
        $satifAmabilite[$v["resto_amabilite"] - 1]++;
    }
    if($v["resto_service"] > 0){
        $satifService[$v["resto_service"] - 1]++;
    }
    if($v["resto_diversite"] > 0){
        $satifDiversite[$v["resto_diversite"] - 1]++;
    }
    if($v["resto_plats"] > 0){
        $satifPlats[$v["resto_plats"] - 1]++;
    }
    if($v["resto_vins"] > 0){
        $satifVins[$v["resto_vins"] - 1]++;
    }
    if($v["resto_prix"] > 0){
        $satifPrix[$v["resto_prix"] - 1]++;
    }
    if($v["revenir"] > 0){
        $revenir[$v["revenir"] - 1]++;
    }
    if($v["recommander"] > 0){
        $recommander[$v["recommander"] - 1]++;
    }
}

$allServicesSatif = [
    array_map($toPercent, $satifChambre),
    array_map($toPercent, $satifRestauration),
    array_map($toPercent, $satifBar),
    array_map($toPercent, $satifAccueil),
    array_map($toPercent, $satifEnvironement),
    array_map($toPercent, $satifRapport)
];
$globalSatisfPercent = array_map($toPercent, $globalSatisf);

$allRestoSatif = [
    array_map($toPercent, $satifAmabilite),
    array_map($toPercent, $satifService),
    array_map($toPercent, $satifDiversite),
    array_map($toPercent, $satifPlats),
    array_map($toPercent, $satifVins),
    array_map($toPercent, $satifPrix),
];

$perceptionPrixPercent = array_map($toPercent, $perceptionPrix);
$revenirPercent = array_map($toPercent, $revenir);
$recommanderPercent = array_map($toPercent, $recommander);


/////////////////////////////////////////
/////////////////////////////////////////
$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$resultsConnaissance = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$resultsConnaissanceTotal = 0;
foreach ($clients as $k => $c) {
    $stmt->bindValue(":id", $c["id"]);
    $stmt->execute();
    $tmp = $stmt->fetchAll();
    if ($tmp) {
        foreach ($tmp as $l => $t) {
            if($t["type_id"]>0){
                $resultsConnaissance[$t["type_id"] - 1]++;
            }
        }
    }
}

for ($i = 0; $i < count($resultsConnaissance); $i++) {
    $resultsConnaissanceTotal += $resultsConnaissance[$i];
}
$resultsConnaissancePercent = array_map(function ($it) use ($resultsConnaissanceTotal) {
    if($resultsConnaissanceTotal>0){
        return round(($it / $resultsConnaissanceTotal) * 100,1);
    }else{
        return 0;
    }

}, $resultsConnaissance);


////////////////////////////////////////////////


////////////////////////////
$clientsParisiens = [];
$clientsParisiensParDeps = [
    "75"=>[],
    "77"=>[],
    "78"=>[],
    "91"=>[],
    "92"=>[],
    "93"=>[],
    "94"=>[],
    "95"=>[],
];
foreach($clients as $k=>$c){
    if(in_array($c["departement_num"], $deptParisNums)){
        $clientsParisiens[] = $c;
    }
    switch($c["departement_num"]){
        case "75":
            $clientsParisiensParDeps["75"][] = $c;
            break;
        case "77":
            $clientsParisiensParDeps["77"][] = $c;
            break;
        case "78":
            $clientsParisiensParDeps["78"][] = $c;
            break;
        case "91":
            $clientsParisiensParDeps["91"][] = $c;
            break;
        case "92":
            $clientsParisiensParDeps["92"][] = $c;
            break;
        case "93":
            $clientsParisiensParDeps["93"][] = $c;
            break;
        case "94":
            $clientsParisiensParDeps["94"][] = $c;
            break;
        case "95":
            $clientsParisiensParDeps["95"][] = $c;
            break;
        default:
            break;
    }
}

$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$resultsConnaissanceParis = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$resultsConnaissanceParisTotal = 0;
foreach($clientsParisiens as $k=>$cp){
    $stmt->bindValue(":id", $cp["id"]);
    $stmt->execute();
    $tmp = $stmt->fetchAll();
    if ($tmp) {
        foreach ($tmp as $l => $t) {
            if($t["type_id"]>0){
                $resultsConnaissanceParis[$t["type_id"] - 1]++;
            }
        }
    }
}
for ($i = 0; $i < count($resultsConnaissanceParis); $i++) {
    $resultsConnaissanceParisTotal += $resultsConnaissanceParis[$i];
}
$resultsConnaissanceParisPercent = array_map(function ($it) use ($resultsConnaissanceParisTotal) {
    if($resultsConnaissanceParisTotal>0){
        return round(($it / $resultsConnaissanceParisTotal) * 100,1);
    } else {
        return 0;
    }

}, $resultsConnaissanceParis);

////////////////////////////
$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$resultsConnaissanceParisParDeptsTotal = [
    "75"=>0, "77"=>0, "78"=>0, "91"=>0, "92"=>0, "93"=>0, "94"=>0, "95"=>0,
];
$resultsConnaissanceParisParDepts = [
    "75"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    "77"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    "78"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    "91"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    "92"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    "93"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    "94"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    "95"=>[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
];
foreach($clientsParisiensParDeps as $k=>$deptParis){
    foreach($deptParis as $l=>$c){
        $stmt->bindValue(":id", $c["id"]);
        $stmt->execute();
        $tmp = $stmt->fetchAll();
        if ($tmp) {
            foreach ($tmp as $m => $t) {
                if($t["type_id"]>0){
                    $resultsConnaissanceParisParDepts[$k][$t["type_id"] - 1]++;
                }
            }
        }
    }
    for($i=0;$i<count($resultsConnaissanceParisParDepts[$k]);$i++){
        $resultsConnaissanceParisParDeptsTotal[$k] += $resultsConnaissanceParisParDepts[$k][$i];
    }
}

/////////////////////////// Context du séjour

$sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee AND departement_num=:deptnum";
$stmt = $pdo->prepare($sql);
$effectifsParDept = [];
$effectifsParDeptPercent = [];
$selected = [];
$countEffectifOtherDepts = 0;
foreach($departements as $num=>$name){
    $stmt->bindValue(":arrive_mois", $monthStart);
    $stmt->bindValue(":arrive_annee", $annee);
    $stmt->bindValue(":deptnum", $num);
    $stmt->execute();
    $tmp = $stmt->fetch();
    if($tmp){
        $effectifsParDept[$num] = $tmp["num"];
        if($numEntry>0){
            $effectifsParDeptPercent[$num] = round(($tmp["num"] / $numEntry) * 100,1);
        } else {
            $effectifsParDeptPercent[$num] = 0;
        }

        // selection des departements les plus representatifs
        if($effectifsParDeptPercent[$num] >= 1.5){
            $selected[] = ["dept_num"=>$num, "dept_name"=>$name, "effectif"=>$tmp["num"], "percent"=>$effectifsParDeptPercent[$num]];
        } else {
            $countEffectifOtherDepts += $tmp["num"];
        }
    }
}
// rearragement des departements representatifs dans l'ordre decroissant du pourcentage
usort($selected, function($a,$b){
    if($a["percent"] == $b["percent"]){
        return 0;
    }
    return ($a["percent"] < $b["percent"]) ? 1 : -1;
});

//////////////// temps de trajet
$tpsTrajet = [0,0,0];
foreach($clients as $c){
    if($c["tps_trajet"]>0){
        $tpsTrajet[$c["tps_trajet"] - 1]++;
    }

}
$tpsTrajetPercent = array_map(function($it) use ($numEntry){
    if($numEntry>0){
        return round(($it/$numEntry) * 100,1);
    } else {
        return 0;
    }
}, $tpsTrajet);
////////////


///////////////////// sejour
/////////// nbre personnes
///// adultes
$sql = "SELECT nbre_adulte as ad, nbre_enfant as en FROM sejours WHERE arrive_timestamp >=:datestartts AND arrive_timestamp <=:dateendts";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(":datestartts",$dateStartTs);
$stmt->bindValue(":dateendts",$dateEndTs);
$stmt->execute();

$result = $stmt->fetchAll();
$nbrAdultes = [0,0,0,0,0,0];
$nbrEnfants = [0,0,0,0,0,0];
$counterPersons = 0;
if($result){
    foreach($result as $k=>$v){
        if(($v["ad"] == 6 && $v["ad"] == 6) || ($v["ad"] == 0 && $v["ad"] == 0) || ($v["ad"] == 6 && ($v["en"] == 6 || $v["en"] == 0)) || ($v["ad"] == 0 && ($v["en"] == 6 || $v["en"] == 0))){
            continue;
        }
        $counterPersons++;
        switch($v["ad"]){
            case 0:
            case 6:
            default:
                $nbrAdultes[5]++;
                break;
            case 1:
                $nbrAdultes[0]++;
                break;
            case 2:
                $nbrAdultes[1]++;
                break;
            case 3:
                $nbrAdultes[2]++;
                break;
            case 4:
                $nbrAdultes[3]++;
                break;
            case 5:
                $nbrAdultes[4]++;
                break;
        }
        switch($v["en"]){
            case 0:
            case 6:
            default:
                $nbrEnfants[5]++;
                break;
            case 1:
                $nbrEnfants[0]++;
                break;
            case 2:
                $nbrEnfants[1]++;
                break;
            case 3:
                $nbrEnfants[2]++;
                break;
            case 4:
                $nbrEnfants[3]++;
                break;
            case 5:
                $nbrEnfants[4]++;
                break;
        }
    }
}
$nbrAdultesPercent = array_map(function($it) use($counterPersons){
    if($counterPersons>0){
        return round(($it / $counterPersons) * 100,1);
    } else {
        return 0;
    }

}, $nbrAdultes);
$nbrEnfantsPercent = array_map(function($it) use($counterPersons){
    if($counterPersons>0){
        return round(($it / $counterPersons) * 100,1);
    } else {
        return 0;
    }
}, $nbrEnfants);


//////// chambres /////
$sql = "SELECT type_chambre as room FROM sejours WHERE arrive_timestamp >=:datestartts AND arrive_timestamp <=:dateendts";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(":datestartts",$dateStartTs);
$stmt->bindValue(":dateendts",$dateEndTs);
$stmt->execute();
$result = $stmt->fetchAll();
$countRooms = count($result);
$rooms = [0,0,0,0];
if($result){
    foreach($result as $k=>$v){
        if($v["room"]>0){
            $rooms[$v["room"] - 1]++;
        }

    }
}
$roomsPercent = array_map(function($it) use ($countRooms){
    return round( ($it/$countRooms) * 100,1);
}, $rooms);
//////// combien de nuits
$sql = "SELECT nbre_nuit as nuites FROM sejours WHERE arrive_timestamp >=:datestartts AND arrive_timestamp <=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts",$dateStartTs);
$stmt->bindValue(":dateendts",$dateEndTs);
$stmt->execute();
$result = $stmt->fetchAll();
$countNuites = count($result);
$nuites = [0,0,0,0];
if($result){
    foreach($result as $k=>$v){
        if($v["nuites"] == 1){
            $nuites[0]++;
        }
        if($v["nuites"] == 2){
            $nuites[1]++;
        }
        if($v["nuites"] == 3){
            $nuites[2]++;
        }
        if($v["nuites"] >= 4){
            $nuites[3]++;
        }
    }
}
$nuitesPercent = array_map(function($it) use($countNuites){
    if($countNuites>0){
        return round(($it/$countNuites) * 100);
    } else {
        return 0;
    }

}, $nuites);
///////// visite zoo
$sql = "SELECT visite_zoo as visite FROM sejours WHERE arrive_timestamp >=:datestartts AND arrive_timestamp <=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts",$dateStartTs);
$stmt->bindValue(":dateendts",$dateEndTs);
$stmt->execute();
$result = $stmt->fetchAll();
$countVisite = count($result);
$visiteZoo = [0,0];
if($result){
    foreach($result as $k=>$v){
        if($v["visite"] == 1){
            $visiteZoo[0]++;
        }
        if($v["visite"] == 2){
            $visiteZoo[1]++;
        }
    }
}
$visiteZooPercent = array_map(function($it) use ($countVisite) {
    if($countVisite>0){
        return round(($it/$countVisite) * 100);
    } else{
        return 0;
    }

}, $visiteZoo);
////////// spa
$sql = "SELECT spa FROM satisfaction WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$spa = [0,0,0,0];
$spaCounter = 0;
foreach($clients as $k=>$c){
    $stmt->bindValue(":id", $c["id"]);
    $stmt->execute();
    $tmp = $stmt->fetch();
    if($tmp && $tmp["spa"]>0){
        $spaCounter++;
        $spa[$tmp["spa"] - 1]++;

    }
}
$spaPercent = array_map(function($it) use ($spaCounter){
    if($spaCounter>0){
        return round(($it/$spaCounter) *100);
    } else{
        return 0;
    }

}, $spa);

///////// wifi
$sql = "SELECT wifi FROM sejours WHERE arrive_timestamp >=:datestartts AND arrive_timestamp <=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts",$dateStartTs);
$stmt->bindValue(":dateendts",$dateEndTs);
$stmt->execute();
$stmt->execute();
$result = $stmt->fetchAll();
$wifi = [0,0,0];
$wifiCounter = 0;
if($result){
    foreach($result as $k=>$v){
        if($v["wifi"]>0){
            $wifiCounter++;
            $wifi[$v["wifi"] - 1]++;
        }

    }
}
$wifiPercent = array_map(function($it) use ($wifiCounter){
    if($wifiCounter>0){
        return round(($it/$wifiCounter) * 100);
    } else {
        return 0;
    }

}, $wifi);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//pChart
include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pData.class.php");
include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pDraw.class.php");
include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pPie.class.php");
include_once(LIBS.DIRECTORY_SEPARATOR."pChart".DIRECTORY_SEPARATOR."pImage.class.php");
$baseDir = realpath(__DIR__);
//pie chart satisfaction globale img/satif-globale-annee.png
$datas = new pData();
$datas->addPoints($globalSatisfPercent,"pourcentage");

$legend = [];
foreach($datas_satisfaction_bis as $k=>$v){
    $legend[] = $v . " " . $globalSatisfPercent[$k] ."%";
}

$datas->addPoints($legend,"legende");
$datas->setAbscissa("legende");

$picture = new pImage(600,450,$datas);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$pie = new pPie($picture, $datas);

$pie->draw2DPie(300,250,["Radius"=>140, "DrawLabels"=>true,"Border"=>true, "WriteValues"=>PIE_VALUE_NATURAL,"ValueSuffix"=>"%" ]);
$pie->drawPieLegend(20, 390, ["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"FontR"=>"50","FontG"=>"50","FontB"=>"50"]);
$picture->render($baseDir ."/img/satif-globale-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// bar chart satisfaction services img/services-annee.png
$datas = new pData();
$points = [[],[],[],[]];
foreach($allServicesSatif as $k=>$v){
    foreach($v as $l=>$m){
        $points[$l][] = $m;
    }
}
foreach($points as $k=>$v){
    $datas->addPoints($v, $datas_satisfaction_bis[$k]);
}
$datas->addPoints($datas_services, "legende");
$datas->setAbscissa("legende");
$picture = new pImage(800,450,$datas);
$picture->setGraphArea(300,50,750,400);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_TOPBOTTOM, "Mode"=>SCALE_MODE_ADDALL]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawLegend(20,100);
$picture->drawStackedBarChart(["DisplayOrientation"=>ORIENTATION_VERTICAL]);
$picture->render($baseDir ."/img/services-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// pie chart perception prix img/rapport-qualprix-annee.png
$datas = new pData();
$datas->addPoints($perceptionPrixPercent,"pourcentage");

$legend = [];
foreach($datas_perception_prix as $k=>$v){
    $legend[] = $v . " " . $perceptionPrixPercent[$k] ."%";
}
$datas->addPoints($legend,"legende");
$datas->setAbscissa("legende");

$picture = new pImage(600,450,$datas);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$pie = new pPie($picture, $datas);

$pie->draw2DPie(300,250,["Radius"=>140, "DrawLabels"=>true,"Border"=>true, "WriteValues"=>PIE_VALUE_NATURAL,"ValueSuffix"=>"%" ]);
$pie->drawPieLegend(20, 390, ["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"FontR"=>"50","FontG"=>"50","FontB"=>"50"]);
$picture->render($baseDir ."/img/rapport-qualprix-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// bar chart satisfaction restauration img/restauration-annee.png
$datas = new pData();
$points = [[],[],[],[]];
foreach($allRestoSatif as $k=>$v){
    foreach($v as $l=>$m){
        $points[$l][] = $m;
    }
}
foreach($points as $k=>$v){
    $datas->addPoints($v, $datas_satisfaction_bis[$k]);
}
$datas->addPoints($datas_resto, "legende");
$datas->setAbscissa("legende");
$picture = new pImage(800,450,$datas);
$picture->setGraphArea(300,50,750,400);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_TOPBOTTOM, "Mode"=>SCALE_MODE_ADDALL]);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawLegend(20,100);
$picture->drawStackedBarChart(["DisplayOrientation"=>ORIENTATION_VERTICAL]);
$picture->render($baseDir ."/img/restauration-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// bar chat connaissance hotel total connaissance_total-annee.png
$datas = new pData();
$datas->addPoints($resultsConnaissancePercent, "values");
$datas->addPoints($connaissance_types, "legende");
$datas->setAbscissa("legende");
$picture = new pImage(800,450,$datas);
$picture->setGraphArea(300,50,750,400);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_TOPBOTTOM, "Mode"=>SCALE_MODE_ADDALL]);
$palette = [
    "0"=>["R"=>241,"G"=>225,"B"=>79,"Alpha"=>100],
    "1"=>["R"=>246,"G"=>158,"B"=>16,"Alpha"=>100],
    "2"=>["R"=>227,"G"=>115,"B"=>17,"Alpha"=>100],
    "3"=>["R"=>230,"G"=>97,"B"=>68,"Alpha"=>100],
    "4"=>["R"=>29,"G"=>186,"B"=>214,"Alpha"=>100],
    "5"=>["R"=>47,"G"=>112,"B"=>187,"Alpha"=>100],
    "6"=>["R"=>143,"G"=>126,"B"=>204,"Alpha"=>100],
    "7"=>["R"=>213,"G"=>137,"B"=>196,"Alpha"=>100],
    "8"=>["R"=>123,"G"=>239,"B"=>162,"Alpha"=>100],
    "9"=>["R"=>107,"G"=>197,"B"=>87,"Alpha"=>100],
    "10"=>["R"=>38,"G"=>128,"B"=>18,"Alpha"=>100],
];
$picture->drawBarChart(["DisplayPos"=>LABEL_POS_INSIDE, "DisplayValues"=>true,"DisplayR"=>50,"DisplayG"=>50,"DisplayB"=>50,"OverrideColors"=>$palette]);
$picture->render($baseDir ."/img/connaissance_total-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// bar chat connaissance hotel total connaissance_paris-annee.png
$datas = new pData();
$datas->addPoints($resultsConnaissanceParisPercent, "values");
$datas->addPoints($connaissance_types, "legende");
$datas->setAbscissa("legende");
$picture = new pImage(800,350,$datas);
$picture->setGraphArea(300,50,750,300);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_TOPBOTTOM, "Mode"=>SCALE_MODE_ADDALL]);
$palette = [
    "0"=>["R"=>241,"G"=>225,"B"=>79,"Alpha"=>100],
    "1"=>["R"=>246,"G"=>158,"B"=>16,"Alpha"=>100],
    "2"=>["R"=>227,"G"=>115,"B"=>17,"Alpha"=>100],
    "3"=>["R"=>230,"G"=>97,"B"=>68,"Alpha"=>100],
    "4"=>["R"=>29,"G"=>186,"B"=>214,"Alpha"=>100],
    "5"=>["R"=>47,"G"=>112,"B"=>187,"Alpha"=>100],
    "6"=>["R"=>143,"G"=>126,"B"=>204,"Alpha"=>100],
    "7"=>["R"=>213,"G"=>137,"B"=>196,"Alpha"=>100],
    "8"=>["R"=>123,"G"=>239,"B"=>162,"Alpha"=>100],
    "9"=>["R"=>107,"G"=>197,"B"=>87,"Alpha"=>100],
    "10"=>["R"=>38,"G"=>128,"B"=>18,"Alpha"=>100],
];
$picture->drawBarChart(["DisplayPos"=>LABEL_POS_INSIDE, "DisplayValues"=>true,"DisplayR"=>50,"DisplayG"=>50,"DisplayB"=>50,"OverrideColors"=>$palette]);
$picture->render($baseDir ."/img/connaissance_paris-annee.png");

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// pie chart revenir img/revenir-annee.png
$datas = new pData();
$datas->addPoints($revenirPercent,"pourcentage");

$legend = [];
foreach($datas_intentions as $k=>$v){
    $legend[] = $v . " " . $revenirPercent[$k] ."%";
}
$datas->addPoints($legend,"legende");
$datas->setAbscissa("legende");

$picture = new pImage(600,450,$datas);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$pie = new pPie($picture, $datas);

$pie->draw2DPie(300,250,["Radius"=>140, "DrawLabels"=>true,"Border"=>true, "WriteValues"=>PIE_VALUE_NATURAL,"ValueSuffix"=>"%" ]);
$pie->drawPieLegend(20, 390, ["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"FontR"=>"50","FontG"=>"50","FontB"=>"50"]);
$picture->render($baseDir ."/img/revenir-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// pie chart revenir img/recommander-annee.png
$datas = new pData();
$datas->addPoints($recommanderPercent,"pourcentage");

$legend = [];
foreach($datas_intentions as $k=>$v){
    $legend[] = $v . " " . $recommanderPercent[$k] ."%";
}
$datas->addPoints($legend,"legende");
$datas->setAbscissa("legende");

$picture = new pImage(600,450,$datas);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$pie = new pPie($picture, $datas);

$pie->draw2DPie(300,250,["Radius"=>140, "DrawLabels"=>true,"Border"=>true, "WriteValues"=>PIE_VALUE_NATURAL,"ValueSuffix"=>"%" ]);
$pie->drawPieLegend(20, 390, ["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"FontR"=>"50","FontG"=>"50","FontB"=>"50"]);
$picture->render($baseDir ."/img/recommander-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//bar chart type de chambre chambre.png
$datas = new pData();
$datas->addPoints($roomsPercent, "values");
$datas->addPoints($datas_type_chambre, "legende");
$datas->setAbscissa("legende");
$picture = new pImage(800,350,$datas);
$picture->setGraphArea(300,50,750,300);
$picture->setFontProperties(["FontName"=>LIBS . DIRECTORY_SEPARATOR . "fonts/calibri.ttf", "FontSize"=>10,"R"=>"50","G"=>"50","B"=>"50"]);
$picture->drawScale(["Pos"=>SCALE_POS_TOPBOTTOM, "Mode"=>SCALE_MODE_ADDALL]);
$palette = [
    "0"=>["R"=>230,"G"=>97,"B"=>68,"Alpha"=>100],
    "1"=>["R"=>47,"G"=>112,"B"=>187,"Alpha"=>100],
    "2"=>["R"=>213,"G"=>137,"B"=>196,"Alpha"=>100],
    "3"=>["R"=>107,"G"=>197,"B"=>87,"Alpha"=>100]
];
$picture->drawBarChart(["DisplayPos"=>LABEL_POS_INSIDE, "DisplayValues"=>true,"DisplayR"=>50,"DisplayG"=>50,"DisplayB"=>50,"OverrideColors"=>$palette]);
$picture->render($baseDir ."/img/chambre-annee.png");
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

require_once(LIBS . DIRECTORY_SEPARATOR . "html2pdf.class.php");

ob_start();
include(dirname(__FILE__) . "/page_01.php");
include(dirname(__FILE__) . "/page_02.php");
include(dirname(__FILE__) . "/page_03.php");
include(dirname(__FILE__) . "/page_04.php");
include(dirname(__FILE__) . "/page_05.php");
include(dirname(__FILE__) . "/page_06.php");
include(dirname(__FILE__) . "/page_07.php");
include(dirname(__FILE__) . "/page_08.php");
include(dirname(__FILE__) . "/page_09.php");
include(dirname(__FILE__) . "/page_10.php");
include(dirname(__FILE__) . "/page_11.php");
include(dirname(__FILE__) . "/page_12.php");
include(dirname(__FILE__) . "/page_13.php");
include(dirname(__FILE__) . "/page_14.php");
include(dirname(__FILE__) . "/page_15.php");
include(dirname(__FILE__) . "/page_16.php");
include(dirname(__FILE__) . "/page_17.php");

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
