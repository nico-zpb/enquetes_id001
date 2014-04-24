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

// closure

$toPercent = function ($it) use ($numEntry) {
    return round(($it / $numEntry) * 100);
};


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
        $tranchesAge[] = ["name" => $v["name"], "num" => $result["num"], "percent" => round(($result["num"] / $numEntry) * 100)];
    }
}


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
        $prof[] = ["name" => $v["name"], "num" => $result["num"], "percent" => round(($result["num"] / $numEntry) * 100)];
    }

}


// satisfaction
$sql = "SELECT * FROM satisfaction WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$satisfaction = [];
foreach ($clients as $k => $c) {
    $stmt->bindValue(":id", $c["id"]);
    $stmt->execute();
    $satisfaction[] = $stmt->fetch();
}

/////////////////////////////////////////
$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$resultsConnaissance = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$resultsConnaissanceTotal = 0;
foreach ($clients as $k => $c) {
    $stmt->bindValue(":id", $c["id"]);
    $stmt->execute();
    //$resultsConnaissance[] = $stmt->fetchAll();
    $tmp = $stmt->fetchAll();
    if ($tmp) {
        foreach ($tmp as $l => $t) {
            $resultsConnaissance[$t["type_id"] - 1]++;

        }
    }
}

for ($i = 0; $i < count($resultsConnaissance); $i++) {
    $resultsConnaissanceTotal += $resultsConnaissance[$i];
}
$resultsConnaissancePercent = array_map(function ($it) use ($resultsConnaissanceTotal) {
    return round(($it / $resultsConnaissanceTotal) * 100);
}, $resultsConnaissance);
var_dump($resultsConnaissancePercent);
////////////////////////////////////////////////


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
    // satisfaction globale
    $globalSatisf[$v["globalement"] - 1]++;
    $satifChambre[$v["chambres"] - 1]++;
    $satifRestauration[$v["restauration"] - 1]++;
    $satifBar[$v["bar"] - 1]++;
    $satifAccueil[$v["accueil"] - 1]++;
    $satifEnvironement[$v["environnement"] - 1]++;
    $satifRapport[$v["rapport"] - 1]++;
    $perceptionPrix[$v["prix"] - 1]++;
    $satifAmabilite[$v["resto_amabilite"] - 1]++;
    $satifService[$v["resto_service"] - 1]++;
    $satifDiversite[$v["resto_diversite"] - 1]++;
    $satifPlats[$v["resto_plats"] - 1]++;
    $satifVins[$v["resto_vins"] - 1]++;
    $satifPrix[$v["resto_prix"] - 1]++;
    $revenir[$v["revenir"] - 1]++;
    $recommander[$v["recommander"] - 1]++;
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
    }
</script>
<?php
include_once "mois/profil-alone.php";

include_once "mois/satif-global-alone.php";

include_once "mois/origine-alone.php";


?>







