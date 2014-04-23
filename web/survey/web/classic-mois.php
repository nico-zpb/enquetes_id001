<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 11:50
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

if(!isConnected()){
    header("Location: /index.php");
    die();
}


// verif arrive par post
if(!isPost() || !postExists("form_cwm_range")){
    header("Location: /index.php");
    die();
}

$error = false;
$errorMsg = "<strong>Erreur</strong> ";

$form = getPost("form_cwm_range");
$today = new DateTime("now");
$todayMonth = $today->format("n");

$annee = (int)$form["annee"];
$monthStart = (int)$form["month_start"];
$monthEnd = (int)$form["month_end"];

// erreur sur mois
if(!$debug){
    if($monthStart>$todayMonth){
        $error = true;
        $errorMsg .= "Le mois de début de période ne peut être supérieur au mois actuel. ";
    }
    if($monthEnd>$todayMonth){
        $error = true;
        $errorMsg .= "Le mois de fin de période ne peut être supérieur au mois actuel. ";
    }
    if($monthStart>$monthEnd){
        $error = true;
        $errorMsg .= "Le mois de début de période ne peut être supérieur au mois de fin de période. ";
    }
}

if(!$error){
    include_once "../../../php/enquete-connexion.php";

    $monthStartName = $datas_mois[$monthStart - 1];
    $monthEndName = $datas_mois[$monthEnd - 1];
    $multiMonth = false;
//
    if($monthStart == $monthEnd && $monthStart != $todayMonth){
        $period = ucfirst($monthStartName) . " " . $annee . ".";
    } elseif ($monthStart == $monthEnd && $monthStart == $todayMonth) {
        $period = "Ce mois-ci.";
    } else {
        $multiMonth = true;
        $period = "de " . ucfirst($monthStartName) . " " . $annee . " à " . ucfirst($monthEndName) . " " . $annee . ".";
    }


// il y a t-il des résultats sur la periode demandée ?
    $numEntry = 0;
    if(!$multiMonth){
        $sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee";
        $clientNumStmt = $pdo->prepare($sql);
        $clientNumStmt->bindValue(":arrive_mois", $monthStart);
        $clientNumStmt->bindValue(":arrive_annee", $annee);
        $clientNumStmt->execute();
        $countClients = $clientNumStmt->fetch();
        $numEntry = $countClients["num"];
        if(!$numEntry){
            setFlash("Il n'y a pas de résultats sur la période demandée.");
            header("Location: /survey/to-web.php");
            die();
        }
    } else {
        for($i = $monthStart; $i<$monthEnd+1; $i++){
            $sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee";
            $clientNumStmt = $pdo->prepare($sql);
            $clientNumStmt->bindValue(":arrive_mois", $i);
            $clientNumStmt->bindValue(":arrive_annee", $annee);
            $clientNumStmt->execute();
            $countClients = $clientNumStmt->fetch();
            $numEntry += $countClients["num"];
        }
        if(!$numEntry){
            setFlash("Il n'y a pas de résultats sur la période demandée.");
            header("Location: /survey/to-web.php");
            die();
        }
    }
}



//


include_once "../../../php/header.php";
include_once "../../../php/navbar.php";

?>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
            </div>
            <div class="col-md-10">
                <h1>Statistiques</h1>
                <h2>Format Internet - Données par mois</h2>
            </div>
            <div class="col-md-10 col-md-offset-2"></div>
        </div>
    </div>
</div>
<?php if($error): ?>
    <div class="wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger"><p><?php echo $errorMsg; ?></p><p><a class="alert-link" href="/survey/to-web.php">retour</a></p></div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h1><?php echo $period; ?></h1>
                </div>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
    if($multiMonth){
        // TODO classic-multi
        include_once "classic-multi.php";
    } else {
        include_once "classic-alone.php";
    }

?>
        <div class="container">
            <hr/>
            <footer>
                <p>&copy; ZooParc de Beauval 2014</p>
            </footer>
        </div>
    <?php if($multiMonth): ?>
        <script src="/survey/js/apps/mois/multi.js"></script>
    <?php else: ?>
        <script src="/survey/js/apps/mois/alone.js"></script>
    <?php endif; ?>
    </body>
</html>
