<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 14/05/14
 * Time: 08:55
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$startTime = microtime(true);
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

include_once "../../../../../datas/all.php";
include_once "../../../../../php/functions.php";
include_once "../../../../../php/enquete-connexion.php";


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// TODO formulaire pour recup mois
// pour test $monthStart = 4
$monthStart = 4;
$annee = 2014;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$dateStart = DateTime::createFromFormat("j-n-Y","1-" . $monthStart . "-" . $annee);
$dateStartTs = $dateStart->getTimestamp();
$lastDay = $dateStart->format("t");
$dateEnd = DateTime::createFromFormat("j-n-Y",$lastDay . "-" . $monthStart . "-" . $annee);
$dateEndTs = $dateEnd->getTimestamp();

$sql = "SELECT * FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":arrive_mois", $monthStart);
$stmt->bindValue(":arrive_annee", $annee);
$stmt->execute();
$clients = $stmt->fetchAll();
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
$toPercent = function ($it) use ($numEntry) {
    return round(($it / $numEntry) * 100,1);
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
    return round(($it / $resultsConnaissanceTotal) * 100);
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
    return round(($it / $resultsConnaissanceParisTotal) * 100);
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













////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$endTime = microtime(true);

require_once(LIBS . DIRECTORY_SEPARATOR . "html2pdf.class.php");

ob_start();
include(dirname(__FILE__) . "/page_01.php");
include(dirname(__FILE__) . "/page_02.php"); /* sommaire */
include(dirname(__FILE__) . "/page_03.php"); /* profil */
include(dirname(__FILE__) . "/page_04.php"); /* satisfaction globale */
include(dirname(__FILE__) . "/page_05.php"); /* Satisfaction des différents services */
include(dirname(__FILE__) . "/page_06.php"); /* Perception du rapport qualité/prix de l'hôtel */
include(dirname(__FILE__) . "/page_07.php"); /* Satisfaction concernant la restauration */
include(dirname(__FILE__) . "/page_08.php"); /* Intention de revenir (fidélisation) */
include(dirname(__FILE__) . "/page_09.php"); /* Recommandation à des proches */
include(dirname(__FILE__) . "/page_10.php"); /* Origine de la connaissance de l'hôtel - total échantillon */
include(dirname(__FILE__) . "/page_11.php"); /* Origine de la connaissance de l'hôtel - Région Parisienne */
//include(dirname(__FILE__) . "/page_12.php"); /* mensuel - zone - Perception du rapport qualité/prix de l'hôtel */
//include(dirname(__FILE__) . "/page_13.php"); /* mensuel - zone - Satisfaction concernant le SPA */
//include(dirname(__FILE__) . "/page_14.php"); /* mensuel - zone - visite zoo */
//include(dirname(__FILE__) . "/page_15.php"); /* mensuel - zone - revenir */
//include(dirname(__FILE__) . "/page_16.php"); /* mensuel - zone - recommander */
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