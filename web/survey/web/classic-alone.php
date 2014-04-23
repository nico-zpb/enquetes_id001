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
foreach($datas_trancheAge as $k=>$v){

    $stmt->bindValue(":arrive_mois", $monthStart);
    $stmt->bindValue(":arrive_annee", $annee);
    $stmt->bindValue(":age",$v["num"]);
    $stmt->execute();
    $result = $stmt->fetch();
    if($result["num"]){
        if($result["num"] > $max){
            $max = $result["num"];
            $highlightAge = $k;
        }
        $tranchesAge[] = ["name"=>$v["name"], "num"=>$result["num"], "percent"=> round(($result["num"]/$numEntry) * 100)];
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
    $stmt->bindValue(":prof",$v["num"]);
    $stmt->execute();
    $result = $stmt->fetch();
    if($result["num"]){
        if($result["num"] > $max){
            $max = $result["num"];
            $highlightProf = $k;
        }
        $prof[] = ["name"=>$v["name"], "num"=>$result["num"], "percent"=> round(($result["num"]/$numEntry) * 100)];
    }

}


// satisfaction
$sql = "SELECT * FROM satisfaction WHERE client_id=:id";
$stmt = $pdo->prepare($sql);
$satisfaction = [];
foreach($clients as $k=>$c){
    $stmt->bindValue(":id", $c["id"]);
    $stmt->execute();
    $satisfaction[] = $stmt->fetch();
}


// satisfaction globale
$globalSatisf = [0,0,0,0];
$satifChambre = [0,0,0,0];
$satifRestauration = [0,0,0,0];
$satifBar = [0,0,0,0];
$satifAccueil = [0,0,0,0];
$satifEnvironement = [0,0,0,0];
$satifRapport = [0,0,0,0];

$perceptionPrix = [0,0,0];

$satifAmabilite = [0,0,0,0];
$satifService = [0,0,0,0];
$satifDiversite = [0,0,0,0];
$satifPlats = [0,0,0,0];
$satifVins = [0,0,0,0];
$satifPrix = [0,0,0,0];

$revenir = [0,0,0,0,];
$recommander = [0,0,0,0];

foreach($satisfaction as $k=>$v){

    // satisfaction globale
    switch($v["globalement"]){
        case 1:
            $globalSatisf[0]++;
            break;
        case 2:
            $globalSatisf[1]++;
            break;
        case 3:
            $globalSatisf[2]++;
            break;
        case 4:
        default :
            $globalSatisf[3]++;
            break;

    }

    switch($v["chambres"]){
        case 1:
            $satifChambre[0]++;
            break;
        case 2:
            $satifChambre[1]++;
            break;
        case 3:
            $satifChambre[2]++;
            break;
        case 4:
        default :
            $satifChambre[3]++;
            break;
    }
    switch($v["restauration"]){
        case 1:
            $satifRestauration[0]++;
            break;
        case 2:
            $satifRestauration[1]++;
            break;
        case 3:
            $satifRestauration[2]++;
            break;
        case 4:
        default :
            $satifRestauration[3]++;
            break;
    }
    switch($v["bar"]){
        case 1:
            $satifBar[0]++;
            break;
        case 2:
            $satifBar[1]++;
            break;
        case 3:
            $satifBar[2]++;
            break;
        case 4:
        default :
            $satifBar[3]++;
            break;
    }
    switch($v["accueil"]){
        case 1:
            $satifAccueil[0]++;
            break;
        case 2:
            $satifAccueil[1]++;
            break;
        case 3:
            $satifAccueil[2]++;
            break;
        case 4:
        default :
            $satifAccueil[3]++;
            break;
    }
    switch($v["environnement"]){
        case 1:
            $satifEnvironement[0]++;
            break;
        case 2:
            $satifEnvironement[1]++;
            break;
        case 3:
            $satifEnvironement[2]++;
            break;
        case 4:
        default :
            $satifEnvironement[3]++;
            break;
    }
    switch($v["rapport"]){
        case 1:
            $satifRapport[0]++;
            break;
        case 2:
            $satifRapport[1]++;
            break;
        case 3:
            $satifRapport[2]++;
            break;
        case 4:
        default :
            $satifRapport[3]++;
            break;
    }

    switch($v["prix"]){
        case 1:
            $perceptionPrix[0]++;
            break;
        case 2:
            $perceptionPrix[1]++;
            break;
        case 3:
        default :
            $perceptionPrix[2]++;
            break;
    }

    switch($v["resto_amabilite"]){
        case 1:
            $satifAmabilite[0]++;
            break;
        case 2:
            $satifAmabilite[1]++;
            break;
        case 3:
            $satifAmabilite[2]++;
            break;
        case 4:
        default :
            $satifAmabilite[3]++;
            break;
    }

    switch($v["resto_service"]){
        case 1:
            $satifService[0]++;
            break;
        case 2:
            $satifService[1]++;
            break;
        case 3:
            $satifService[2]++;
            break;
        case 4:
        default :
            $satifService[3]++;
            break;
    }
    switch($v["resto_diversite"]){
        case 1:
            $satifDiversite[0]++;
            break;
        case 2:
            $satifDiversite[1]++;
            break;
        case 3:
            $satifDiversite[2]++;
            break;
        case 4:
        default :
            $satifDiversite[3]++;
            break;
    }
    switch($v["resto_plats"]){
        case 1:
            $satifPlats[0]++;
            break;
        case 2:
            $satifPlats[1]++;
            break;
        case 3:
            $satifPlats[2]++;
            break;
        case 4:
        default :
            $satifPlats[3]++;
            break;
    }

    switch($v["resto_vins"]){
        case 1:
            $satifVins[0]++;
            break;
        case 2:
            $satifVins[1]++;
            break;
        case 3:
            $satifVins[2]++;
            break;
        case 4:
        default :
            $satifVins[3]++;
            break;
    }

    switch($v["resto_prix"]){
        case 1:
            $satifPrix[0]++;
            break;
        case 2:
            $satifPrix[1]++;
            break;
        case 3:
            $satifPrix[2]++;
            break;
        case 4:
        default :
            $satifPrix[3]++;
            break;
    }

    switch($v["revenir"]){
        case 1:
            $revenir[0]++;
            break;
        case 2:
            $revenir[1]++;
            break;
        case 3:
            $revenir[2]++;
            break;
        case 4:
        default :
            $revenir[3]++;
            break;
    }

    switch($v["recommander"]){
        case 1:
            $recommander[0]++;
            break;
        case 2:
            $recommander[1]++;
            break;
        case 3:
            $recommander[2]++;
            break;
        case 4:
        default :
            $recommander[3]++;
            break;
    }
}
$toPercent  = function($it) use ($numEntry){
    return round(($it / $numEntry) *100);
};



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
        dataSource:[
            <?php foreach($datas_services as $k=>$v): ?>
            {category: "<?php echo $v; ?>", satifTres: <?php echo $allServicesSatif[$k][0]; ?>, satif: <?php echo $allServicesSatif[$k][1]; ?>, satifpeu: <?php echo $allServicesSatif[$k][2]; ?>, satifpas: <?php echo $allServicesSatif[$k][3]; ?>},
            <?php endforeach; ?>
        ],
        commonSeriesSettings: {
            argumentField: 'category',
            type: 'stackedBar'
        },
        series:[
            { valueField: "satifTres", name:"très satisfait"},
            { valueField: "satif", name:"satisfait"},
            { valueField: "satifpeu", name:"peu satisfait"},
            { valueField: "satifpas", name:"pas du tout satisfait"}
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
        dataSource:[
            <?php foreach($datas_resto as $k=>$v): ?>
            {category: "<?php echo $v; ?>", satifTres: <?php echo $allRestoSatif[$k][0]; ?>, satif: <?php echo $allRestoSatif[$k][1]; ?>, satifpeu: <?php echo $allRestoSatif[$k][2]; ?>, satifpas: <?php echo $allRestoSatif[$k][3]; ?>},
            <?php endforeach; ?>
        ],
        commonSeriesSettings: {
            argumentField: 'category',
            type: 'stackedBar'
        },
        series:[
            { valueField: "satifTres", name:"très satisfait"},
            { valueField: "satif", name:"satisfait"},
            { valueField: "satifpeu", name:"peu satisfait"},
            { valueField: "satifpas", name:"pas du tout satisfait"}
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
</script>
<?php
include_once "mois/profil-alone.php";

include_once "mois/satif-global-alone.php";
?>







