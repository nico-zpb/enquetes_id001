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

}


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
</script>
<?php
include_once "mois/profil-alone.php";

include_once "mois/satif-global-alone.php";
?>







