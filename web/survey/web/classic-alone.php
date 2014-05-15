<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 12:34
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



/////////////////////////
$dateStart = DateTime::createFromFormat("j-n-Y","1-" . $monthStart . "-" . $annee);
$dateStartTs = $dateStart->getTimestamp();
$lastDay = $dateStart->format("t");
$dateEnd = DateTime::createFromFormat("j-n-Y",$lastDay . "-" . $monthStart . "-" . $annee);
$dateEndTs = $dateEnd->getTimestamp();
// rappel $numEntry

$sql = "SELECT * FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee AND sexe=:sexe";
$clientMaleStmt = $pdo->prepare($sql);
$clientMaleStmt->bindValue(":arrive_mois", $monthStart);
$clientMaleStmt->bindValue(":arrive_annee", $annee);
$clientMaleStmt->bindValue(":sexe", 1);
$clientMaleStmt->execute();
$clientResultMale = $clientMaleStmt->fetchAll();
$sql = "SELECT * FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee AND sexe=:sexe";
$clientFemaleStmt = $pdo->prepare($sql);
$clientFemaleStmt->bindValue(":arrive_mois", $monthStart);
$clientFemaleStmt->bindValue(":arrive_annee", $annee);
$clientFemaleStmt->bindValue(":sexe", 2);
$clientFemaleStmt->execute();
$clientResultFemale = $clientFemaleStmt->fetchAll();
// sex ratio brut
$numMale = count($clientResultMale);
$numFemale = count($clientResultFemale);
// sex ratio percent
$numMalePercent = round(($numMale / $numEntry) * 100);
$numFemalePercent = round(($numFemale / $numEntry) * 100);


$clients = array_merge($clientResultMale, $clientResultFemale);


// tranches d'age
$sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee AND tranche_age=:age";
$stmt = $pdo->prepare($sql);
$tranchesAge = [];
$max = 0;
$highlightAge = null;
foreach ($datas_trancheAge as $k => $v) {

    $stmt->bindValue(":arrive_mois", $monthStart);
    $stmt->bindValue(":arrive_annee", $annee);
    $stmt->bindValue(":age", $v["num"]);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result["num"]) {
        if ($result["num"] > $max) {
            $max = $result["num"];
            $highlightAge = $k;
        }
        $tranchesAge[] = ["name" => $v["name"], "num" => $result["num"], "percent" => round(($result["num"] / $numEntry) * 100,1)];
    }
}
//

// profession
$max = 0;
$highlightProf = null;
$prof = [];
$sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee AND profession=:prof";
$stmt = $pdo->prepare($sql);
foreach ($datas_professions as $k => $v) {
    $stmt->bindValue(":arrive_mois", $monthStart);
    $stmt->bindValue(":arrive_annee", $annee);
    $stmt->bindValue(":prof", $v["num"]);
    $stmt->execute();
    $result = $stmt->fetch();
    if ($result["num"]) {
        if ($result["num"] > $max) {
            $max = $result["num"];
            $highlightProf = $k;
        }
        $prof[] = ["name" => $v["name"], "num" => $result["num"], "percent" => round(($result["num"] / $numEntry) * 100,1)];
    }

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
    return round(($it / $resultsConnaissanceTotal) * 100,1);
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
    return round(($it / $resultsConnaissanceParisTotal) * 100,1);
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
        $effectifsParDeptPercent[$num] = round(($tmp["num"] / $numEntry) * 100,1);
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
    return round(($it/$numEntry) * 100,1);
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
    return round(($it / $counterPersons) * 100,1);
}, $nbrAdultes);
$nbrEnfantsPercent = array_map(function($it) use($counterPersons){
    return round(($it / $counterPersons) * 100,1);
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
    return round(($it/$countNuites) * 100);
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
    return round(($it/$countVisite) * 100);
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
    return round(($it/$spaCounter) *100);
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
    return round(($it/$wifiCounter) * 100);
}, $wifi);
?>
<script src="/survey/js/vendor/globalize.min.js"></script>
<script src="/survey/js/vendor/dx.chartjs.js"></script>
<script>
    var pieChartGlobalSatisf = {
        dataSource: [
            <?php foreach($datas_satisfaction as $k=>$v): ?>
            {category: "<?php echo $v["name"]; ?>", value: <?php echo round(($globalSatisf[$k] / $numEntry) * 100); ?>},
            <?php endforeach; ?>
        ],
        series: {
            argumentField: 'category',
            valueField: 'value',
            label: {
                visible: true,
                connector: {
                    visible: true
                }
            }
        },
        tooltip: {
            enabled: true,
            percentPrecision: 2,
            customizeText: function (value) {
                return value.percentText;
            }
        }
    };

    var fullStackedBarServicesSatif = {
        dataSource: [
            <?php foreach($datas_services as $k=>$v): ?>
            {category: "<?php echo $v; ?>", satifTres: <?php echo $allServicesSatif[$k][0]; ?>, satif: <?php echo $allServicesSatif[$k][1]; ?>, satifpeu: <?php echo $allServicesSatif[$k][2]; ?>, satifpas: <?php echo $allServicesSatif[$k][3]; ?>},
            <?php endforeach; ?>
        ],
        commonSeriesSettings: {
            argumentField: 'category',
            type: 'stackedBar'
        },
        series: [
            { valueField: "satifTres", name: "très satisfait"},
            { valueField: "satif", name: "satisfait"},
            { valueField: "satifpeu", name: "peu satisfait"},
            { valueField: "satifpas", name: "pas du tout satisfait"}
        ],
        tooltip: {
            enabled: true,
            customizeText: function () {
                return this.seriesName + " " + this.valueText + "%";
            }
        }
    };

    var pieChartPerceptionPrix = {
        dataSource: [
            <?php foreach($datas_perception_prix as $k=>$v): ?>
            {category: "<?php echo $v; ?>", value: <?php echo $perceptionPrixPercent[$k]; ?>},
            <?php endforeach; ?>
        ],
        series: {
            argumentField: 'category',
            valueField: 'value',
            label: {
                visible: true,
                connector: {
                    visible: true
                }
            }
        },
        tooltip: {
            enabled: true,
            percentPrecision: 2,
            customizeText: function (value) {
                return value.percentText;
            }
        }
    };

    var fullStackedBarRestoSatif = {
        dataSource: [
            <?php foreach($datas_resto as $k=>$v): ?>
            {category: "<?php echo $v; ?>", satifTres: <?php echo $allRestoSatif[$k][0]; ?>, satif: <?php echo $allRestoSatif[$k][1]; ?>, satifpeu: <?php echo $allRestoSatif[$k][2]; ?>, satifpas: <?php echo $allRestoSatif[$k][3]; ?>},
            <?php endforeach; ?>
        ],
        commonSeriesSettings: {
            argumentField: 'category',
            type: 'stackedBar'
        },
        series: [
            { valueField: "satifTres", name: "très satisfait"},
            { valueField: "satif", name: "satisfait"},
            { valueField: "satifpeu", name: "peu satisfait"},
            { valueField: "satifpas", name: "pas du tout satisfait"}
        ],
        tooltip: {
            enabled: true,
            customizeText: function () {
                return this.seriesName + " " + this.valueText + "%";
            }
        }
    };

    var pieChartRevenir = {
        dataSource: [
            <?php foreach($datas_intentions as $k=>$v): ?>
            {category: "<?php echo $v; ?>", value: <?php echo $revenirPercent[$k]; ?>},
            <?php endforeach; ?>
        ],
        series: {
            argumentField: 'category',
            valueField: 'value',
            label: {
                visible: true,
                connector: {
                    visible: true
                }
            }
        },
        tooltip: {
            enabled: true,
            percentPrecision: 2,
            customizeText: function (value) {
                return value.percentText;
            }
        }
    };

    var pieChartRecommander = {
        dataSource: [
            <?php foreach($datas_intentions as $k=>$v): ?>
            {category: "<?php echo $v; ?>", value: <?php echo $recommanderPercent[$k]; ?>},
            <?php endforeach; ?>
        ],
        series: {
            argumentField: 'category',
            valueField: 'value',
            label: {
                visible: true,
                connector: {
                    visible: true
                }
            }
        },
        tooltip: {
            enabled: true,
            percentPrecision: 2,
            customizeText: function (value) {
                return value.percentText;
            }
        }
    };

    var barChartConnaissanceTotal = {
        rotated: true,
        dataSource: [
            <?php foreach($connaissance_types as $k=>$v): ?>
            {category: "<?php echo $v; ?>", value: <?php echo $resultsConnaissancePercent[$k]; ?>},
            <?php endforeach; ?>
        ],
        series: {
            argumentField: 'category',
            valueField: 'value',
            name: "Totalité échantillon",
            type: 'bar',
            label: {
                visible: true,
                customizeText: function () {
                    return this.valueText + "%";
                }
            }
        },
        tooltip: {
            enabled: true,
            customizeText: function () {
                return this.valueText + "%";
            }
        }
    };

    var barChartConnaissanceParis = {
        rotated: true,
        dataSource: [
            <?php foreach($connaissance_types as $k=>$v): ?>
            {category: "<?php echo $v; ?>", value: <?php echo $resultsConnaissanceParisPercent[$k]; ?>},
            <?php endforeach; ?>
        ],
        series: {
            argumentField: 'category',
            valueField: 'value',
            name: "Région Parisienne",
            type: 'bar',
            label: {
                visible: true,
                customizeText: function () {
                    return this.valueText + "%";
                }
            }
        },
        tooltip: {
            enabled: true,
            customizeText: function () {
                return this.valueText + "%";
            }
        }
    };

    var barChartTypeRooms = {
        rotated: true,
        dataSource: [
            <?php foreach($datas_type_chambre as $k=>$v): ?>
            {category: "<?php echo $v; ?>", value: <?php echo $roomsPercent[$k]; ?>},
            <?php endforeach; ?>
        ],
        series: {
            argumentField: 'category',
            valueField: 'value',
            name: "Types de chambre",
            type: 'bar',
            label: {
                visible: true,
                customizeText: function () {
                    return this.valueText + "%";
                }
            }
        },
        tooltip: {
            enabled: true,
            customizeText: function () {
                return this.valueText + "%";
            }
        }
    };
</script>
<?php
include_once "mois/profil-alone.php";

include_once "mois/satif-global-alone.php";

include_once "mois/origine-alone.php";

include_once "mois/context-alone.php";

include_once "mois/autres-alone.php";
?>







