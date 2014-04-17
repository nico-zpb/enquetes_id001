<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 16/04/2014
 * Time: 13:46
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

if(strtolower($_SERVER["REQUEST_METHOD"]) != "post" || empty($_POST)){
    header("Location: /index.php");
    die();
}

include_once "../datas/all.php";
$depts_num = array_keys($departements);

$date = new DateTime('now', new DateTimeZone("Europe/Paris"));
$year = (int)$date->format("Y");

$f = $_POST["form"];

// ##################  Q1 ################## //
$q1_1 = isset($f["q1"]["res_1"]) ? 1 : 0;
$q1_2 = isset($f["q1"]["res_2"]) ? 1 : 0;
$q1_3 = isset($f["q1"]["res_3"]) ? 1 : 0;
$q1_4 = isset($f["q1"]["res_4"]) ? 1 : 0;
$q1_5 = isset($f["q1"]["res_5"]) ? 1 : 0;
$q1_6 = isset($f["q1"]["res_6"]) ? 1 : 0;
$q1_7 = isset($f["q1"]["res_7"]) ? 1 : 0;
$q1_8 = isset($f["q1"]["res_8"]) ? 1 : 0;
$q1_9 = isset($f["q1"]["res_9"]) ? 1 : 0;
$q1_10 = isset($f["q1"]["res_10"]) ? 1 : 0;
$q1_11 = isset($f["q1"]["res_11"]) ? 1 : 0;
$q1_12 = isset($f["q1"]["res_12"]) ? htmlentities(strip_tags($f["q1"]["res_12"]),ENT_COMPAT|ENT_HTML5) : "";



// ##################  Q2 ################## //
// clients
// departement_num
$q2_1 = isset($f["q2"]["res_1"]) ? htmlentities(strip_tags($f["q2"]["res_1"]), ENT_COMPAT|ENT_HTML5) : "";
if(preg_match("/^[1-9]$/",$q2_1)){
    $q2_1 = "0" . $q2_1;
}
if(!in_array($q2_1, $depts_num)){
    $q2_1  = "";
}
// clients
$departement_name = $departements[$q2_1];
// pays
// clients
$q2_2 = isset($f["q2"]["res_2"]) ? htmlentities(strip_tags($f["q2"]["res_2"]), ENT_COMPAT|ENT_HTML5) : "";




// ##################  Q3 ################## //
// clients
// temps de trajet
$q3 = (isset($f["q3"]) && is_numeric($f["q3"]) &&  $f["q3"] > 0 && $f["q3"] < 4)? (int) $f["q3"] : 0;




// ##################  Q4 ################## //
// sejours
// type chambre
$q4 = isset($f["q4"]) && is_numeric($f["q4"]) && $f["q4"]>0 && $f["q4"]<5 ? (int) $f["q4"] : 0;






// ##################  Q5 ################## //
// clients
$date = new DateTime('now', new DateTimeZone("Europe/Paris"));

$q5_annee =     ( isset( $f["q5"]["annee"] )  && is_numeric( $f["q5"]["annee"] )    && $f["q5"]["annee"] > 2000 && $f["q5"]["annee"] < $year+1) ?   $f["q5"]["annee"]           : $date->format("Y");
$q5_mois =      ( isset( $f["q5"]["mois"] )   && is_numeric( $f["q5"]["mois"] )     && $f["q5"]["mois"] > 0     && $f["q5"]["mois"] < 13) ?         (int)$f["q5"]["mois"]       : $date->format("n");
$q5_jour =      ( isset( $f["q5"]["jour"] )   && is_numeric( $f["q5"]["jour"] )     && $f["q5"]["jour"] > 0     && $f["q5"]["jour"] < 32) ?         (int)$f["q5"]["jour"]       : $date->format("j");

$date_arrivee = DateTime::createFromFormat("j-n-Y",$q5_jour . "-" . $q5_mois . "-" . $q5_annee,new DateTimeZone("Europe/Paris"));

// clients + sejour
$arrivee_timestamp = $date_arrivee->getTimestamp();



// ##################  Q6 ################## //
// sejours
// nuites
$q6 = (isset($f["q6"]) && is_numeric($f["q6"])) ? (int) $f["q6"] : 0;







// ##################  Q7 ################## //
// sejours
// adultes
$q7_1 = (isset($f["q7_1"]) && is_numeric($f["q7_1"]) && $f["q7_1"] > -1 && $f["q7_1"] < 6) ? (int) $f["q7_1"] : 0;
// enfants
$q7_2 = (isset($f["q7_2"]) && is_numeric($f["q7_2"]) && $f["q7_2"] > -1 && $f["q7_2"] < 6) ? (int) $f["q7_2"] : 0;








// ##################  Q8 ################## //
// satisfaction
// globalement
$q8 = (isset($f["q8"]) && is_numeric($f["q8"])  && $f["q8"] > 0 && $f["q8"] < 5) ? (int) $f["q8"] : 0;





// ##################  Q9 ################## //
// satisfaction
// prix
$q9 = (isset($f["q9"]) && is_numeric($f["q9"]) && $f["q9"] > 0 && $f["q9"] < 4) ? (int) $f["q9"] : 0;





// ##################  Q10 ################## //
// satisfaction
//chambres
$q10_1 = (isset($f["q10_1"]) && is_numeric($f["q10_1"]) && $f["q10_1"] > 0 && $f["q10_1"] < 5) ? (int) $f["q10_1"] : 0;
//restauration
$q10_2 = (isset($f["q10_2"]) && is_numeric($f["q10_2"]) && $f["q10_2"] > 0 && $f["q10_2"] < 5) ? (int) $f["q10_2"] : 0;
//bar
$q10_3 = (isset($f["q10_3"]) && is_numeric($f["q10_3"]) && $f["q10_3"] > 0 && $f["q10_3"] < 5) ? (int) $f["q10_3"] : 0;
//accueil
$q10_4 = (isset($f["q10_4"]) && is_numeric($f["q10_4"]) && $f["q10_4"] > 0 && $f["q10_4"] < 5) ? (int) $f["q10_4"] : 0;
//environnement
$q10_5 = (isset($f["q10_5"]) && is_numeric($f["q10_5"]) && $f["q10_5"] > 0 && $f["q10_5"] < 5) ? (int) $f["q10_5"] : 0;
//rapport
$q10_6 = (isset($f["q10_6"]) && is_numeric($f["q10_6"]) && $f["q10_6"] > 0 && $f["q10_6"] < 5) ? (int) $f["q10_6"] : 0;







// ##################  Q11 ################## //
// satisfaction
//resto_amabilite
$q11_1 = (isset($f["q11_1"]) && is_numeric($f["q11_1"]) && $f["q11_1"] > 0 && $f["q11_1"] < 5) ? (int) $f["q11_1"] : 0;
//resto_service
$q11_2 = (isset($f["q11_2"]) && is_numeric($f["q11_2"]) && $f["q11_2"] > 0 && $f["q11_2"] < 5) ? (int) $f["q11_2"] : 0;
//resto_diversite
$q11_3 = (isset($f["q11_3"]) && is_numeric($f["q11_3"]) && $f["q11_3"] > 0 && $f["q11_3"] < 5) ? (int) $f["q11_3"] : 0;
//resto_plats
$q11_4 = (isset($f["q11_4"]) && is_numeric($f["q11_4"]) && $f["q11_4"] > 0 && $f["q11_4"] < 5) ? (int) $f["q11_4"] : 0;
//resto_vins
$q11_5 = (isset($f["q11_5"]) && is_numeric($f["q11_5"]) && $f["q11_5"] > 0 && $f["q11_5"] < 5) ? (int) $f["q11_5"] : 0;
//resto_prix
$q11_6 = (isset($f["q11_6"]) && is_numeric($f["q11_6"]) && $f["q11_6"] > 0 && $f["q11_6"] < 5) ? (int) $f["q11_6"] : 0;






// ##################  Q12 ################## //
// satisfaction
// spa
$q12 = (isset($f["q12"]) && is_numeric($f["q12"]) && $f["q12"] > 0 && $f["q12"] < 5) ? (int) $f["q12"] : 0;




// ##################  Q13 ################## //
// sejours
// wifi
$q13 = (isset($f["q13"]) && is_numeric($f["q13"]) && $f["q13"] > 0 && $f["q13"] < 4) ? (int) $f["q13"] : 0;



// ##################  Q14 ################## //
// sejours
// zoo
$q14 = (isset($f["q14"]) && is_numeric($f["q14"]) && ($f["q14"] == 1 || $f["q14"]==2)) ? $f["q14"] : 2;



// ##################  Q15 ################## //
// satisfaction
// revenir
$q15 = (isset($f["q15"]) && is_numeric($f["q15"]) && $f["q15"] > 0 && $f["q15"] < 5) ? (int) $f["q15"] : 0;




// ##################  Q16 ################## //
// satisfaction
// recommander
$q16 = (isset($f["q16"]) && is_numeric($f["q16"]) && $f["q16"] > 0 && $f["q16"] < 5) ? (int) $f["q16"] : 0;




// ##################  Q17 ################## //
// clients
// commentaire
$q17 = isset($f["q17"]) ? htmlentities(strip_tags($f["q17"]), ENT_COMPAT|ENT_HTML5) : "";





// ##################  Q18 ################## //
// clients
// sexe
$q18 = (isset($f["q18"]) && is_numeric($f["q18"])) ? (int) $f["q18"] : 0;




// ##################  Q19 ################## //
// clients
// tranche d'age
$q19 = (isset($f["q19"]) && is_numeric($f["q19"]) && $f["q19"] > 0 && $f["q19"] < 7) ? (int) $f["q19"] : 0;





// ##################  Q20 ################## //
// clients
// profession
$q20 = (isset($f["q20"]) && is_numeric($f["q20"]) && $f["q20"] > -1 && $f["q20"] < count($profession)+1) ? (int) $f["q20"] : 0;





// ##################  Q21 ################## //
// clients
//infos
$q21 = (isset($f["q21"]) && is_numeric($f["q21"]) && ($f["q21"] == 1 || $f["q21"]==2)) ? $f["q21"] : 2;

// clients
$q_nom = isset($f["q_nom"]) ? htmlentities(strip_tags($f["q_nom"])) : "";


$q_prenom = isset($f["q_prenom"]) ? htmlentities(strip_tags($f["q_prenom"])) : "";


$q_email = isset($f["q_email"]) ? htmlentities(strip_tags($f["q_email"])) : "";

try{
    $pdo = new PDO("sqlite:../db/enquetes_hjdb.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}

// insert client

$sql = "INSERT INTO clients (departement_num, arrive_annee, arrive_mois, arrive_jour, arrive_timestamp, pays, sexe, tranche_age, nom, prenom, email, infos, profession, tps_trajet, commentaire, departement_name) VALUES (:departement_num, :arrive_annee, :arrive_mois, :arrive_jour, :arrive_timestamp, :pays, :sexe, :tranche_age, :nom, :prenom, :email, :infos, :profession, :tps_trajet, :commentaire, :departement_name)";

$stmt = $pdo->prepare($sql);

$stmt->bindValue(":departement_num",$q2_1);
$stmt->bindValue(":arrive_annee",$q5_annee);
$stmt->bindValue(":arrive_mois",$q5_mois);
$stmt->bindValue(":arrive_jour",$q5_jour);
$stmt->bindValue(":arrive_timestamp",$arrivee_timestamp);
$stmt->bindValue(":pays",$q2_2);
$stmt->bindValue(":sexe",$q18);
$stmt->bindValue(":tranche_age",$q19);
$stmt->bindValue(":nom",$q_nom);
$stmt->bindValue(":prenom",$q_prenom);
$stmt->bindValue(":email",$q_email);
$stmt->bindValue(":infos",$q21);
$stmt->bindValue(":profession",$q20);
$stmt->bindValue(":tps_trajet",$q3);
$stmt->bindValue(":commentaire",$q17);
$stmt->bindValue(":departement_name",$departement_name);

$stmt->execute();
$client_id = $pdo->lastInsertId();

// insert sejour
$sql="INSERT INTO sejours (client_id, nbre_nuit, nbre_adulte, nbre_enfant, wifi, visite_zoo, type_chambre, arrive_timestamp) VALUES (:client_id, :nbre_nuit, :nbre_adulte, :nbre_enfant, :wifi, :visite_zoo, :type_chambre, :arrive_timestamp)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":client_id",$client_id);
$stmt->bindValue(":nbre_nuit",$q6);
$stmt->bindValue(":nbre_adulte",$q7_1);
$stmt->bindValue(":nbre_enfant",$q7_2);
$stmt->bindValue(":wifi",$q13);
$stmt->bindValue(":visite_zoo",$q14);
$stmt->bindValue(":type_chambre",$q4);
$stmt->bindValue(":arrive_timestamp",$arrivee_timestamp);
$stmt->execute();

// insert satisfaction
$sql="INSERT INTO satisfaction (chambres, restauration, bar, accueil, environnement, rapport, resto_amabilite, resto_service, resto_diversite, resto_plats, resto_vins, resto_prix, spa, revenir, recommander, prix, client_id, globalement) VALUES (:chambres, :restauration, :bar, :accueil, :environnement, :rapport, :resto_amabilite, :resto_service, :resto_diversite, :resto_plats, :resto_vins, :resto_prix, :spa, :revenir, :recommander, :prix, :client_id, :globalement)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":chambres",$q10_1);
$stmt->bindValue(":restauration",$q10_2 );
$stmt->bindValue(":bar",$q10_3);
$stmt->bindValue(":accueil",$q10_4);
$stmt->bindValue(":environnement",$q10_5);
$stmt->bindValue(":rapport",$q10_6);
$stmt->bindValue(":resto_amabilite",$q11_1);
$stmt->bindValue(":resto_service",$q11_2);
$stmt->bindValue(":resto_diversite",$q11_3);
$stmt->bindValue(":resto_plats",$q11_4);
$stmt->bindValue(":resto_vins",$q11_5);
$stmt->bindValue(":resto_prix",$q11_6);
$stmt->bindValue(":spa",$q12);
$stmt->bindValue(":revenir",$q15);
$stmt->bindValue(":recommander",$q16);
$stmt->bindValue(":prix",$q9);
$stmt->bindValue(":client_id",$client_id);
$stmt->bindValue(":globalement",$q8);
$stmt->execute();

// insert connaissance/custom
$sql="INSERT INTO client_connaissance_type (client_id, type_id) VALUES (:client_id, :type_id)";

for($i=0; $i<11; $i++){
    $val = $i+1;
    $tmp = "q1_" . $val;
    if(${$tmp} == 1){
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":client_id",$client_id);
        $stmt->bindValue(":type_id", $val);
        $stmt->execute();
    }

    if($tmp == "q1_11" && ${$tmp} == 1){
        $sqlc = "INSERT INTO connaissance_type_custom (name, client_id) VALUES (:name, :client_id)";
        $stmtc = $pdo->prepare($sqlc);
        $stmtc->bindValue(":name", $q1_12);
        $stmtc->bindValue(":client_id", $client_id);
        $stmtc->execute();
    }
}

