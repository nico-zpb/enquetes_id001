<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 18/04/14
 * Time: 15:26
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

include_once "../../php/enquete-connexion.php";
include_once "../../php/functions.php";
include_once "../../datas/all.php";
include_once "../../datas/prenoms.php";




function create(){
    // client
    global $pdo;
    global $departements;
    global $pays;
    global $prenoms;

    $n = rand(0,250);
    $sexe = rand(1,2);
    $nom = $prenoms[$n];
    $n = rand(0,250);
    $prenom = $prenoms[$n];
    $email = $prenom . "." . $nom . "@mail.com";
    $prof = rand(1,8);
    $age = rand(1,6);
    $info = rand(1,2);
    $tpsTrajet = rand(1,3);

    $pondereDepts = [1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,3,3,3,3,3,3,4,4,4,];
    shuffle($pondereDepts);
    $n = $pondereDepts[rand(0,26)];
    $depsCentre = ["18","28","36","37","41","45"];
    $depsParis = ["75","77","78","91","92","93","94","95"];
    $depsLimit = ["03","23","49","58","72","86","87","89"];
    $thePays = "France";
    if($n==1){
        $t = rand(0, 5);
        $departementNum = $depsCentre[$t];
        $departement = $departements[$departementNum];
    } elseif($n==2){
        $t = rand(0, 7);
        $departementNum = $depsParis[$t];
        $departement = $departements[$departementNum];
    } elseif($n==3){
        $t = rand(0, 7);
        $departementNum = $depsLimit[$t];
        $departement = $departements[$departementNum];
    } else {
        $t = rand(0,100);
        $departement = array_values($departements)[$t];
        $departementNum = array_keys($departements)[$t];
        if($t == 100){
            $np = rand(0,6);
            $thePays = $pays[$np];
        } else {
            $thePays = "France";
        }
    }

    $date = [];
    $date["annee"] = 2014;
    $pondereMonth = [1,1,1,2,2,2,2,2,3,3,3,4,4,4,4,4,4,5,5,5,5,6,6,6,7,7,7,7,7,7,7,7,7,7,8,8,8,8,8,8,8,8,8,8,9,9,9,9,10,10,10,11,11,11,11,12,12];
    shuffle($pondereMonth);
    $rMonth = rand(0, count($pondereMonth)-1);
    $date["mois"] = $pondereMonth[$rMonth];
    if(in_array($date["mois"], [1,3,5,7,8,10,12])){
        $date["jour"] = rand(1,31);
    } else if(in_array($date["mois"], [4,6,9,11])){
        $date["jour"] = rand(1,30);
    } else {
        $date["jour"] = rand(1,28);
    }
    $theDate = DateTime::createFromFormat("j-n-Y", $date["jour"]."-".$date["mois"]."-".$date["annee"], new DateTimeZone("Europe/paris"));

    $date["timestamp"] = $theDate->getTimestamp();


    $sql = "INSERT INTO clients (departement_num, arrive_annee, arrive_mois, arrive_jour, arrive_timestamp, pays, sexe, tranche_age, nom, prenom, email, infos, profession, tps_trajet, commentaire, departement_name) VALUES (:departement_num, :arrive_annee, :arrive_mois, :arrive_jour, :arrive_timestamp, :pays, :sexe, :tranche_age, :nom, :prenom, :email, :infos, :profession, :tps_trajet, :commentaire, :departement_name)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(":departement_num",$departementNum);
    $stmt->bindValue(":arrive_annee",$date["annee"]);
    $stmt->bindValue(":arrive_mois",$date["mois"]);
    $stmt->bindValue(":arrive_jour",$date["jour"]);
    $stmt->bindValue(":arrive_timestamp",$date["timestamp"]);
    $stmt->bindValue(":pays",$thePays);
    $stmt->bindValue(":sexe",$sexe);
    $stmt->bindValue(":tranche_age",$age);
    $stmt->bindValue(":nom",$nom);
    $stmt->bindValue(":prenom",$prenom);
    $stmt->bindValue(":email",$email);
    $stmt->bindValue(":infos",$info);
    $stmt->bindValue(":profession",$prof);
    $stmt->bindValue(":tps_trajet",$tpsTrajet);
    $stmt->bindValue(":commentaire","");
    $stmt->bindValue(":departement_name",$departement);

    $stmt->execute();
    $client_id = $pdo->lastInsertId();

    $nbrNuit = rand(1,7);
    $nbrAdulte = rand(1,6);
    $nbrEnfant = rand(1,6);
    $wifi = rand(1,3);
    $visiteZoo = rand(1,2);
    $typeChambre = rand(1,4);


    // insert sejour
    $sql="INSERT INTO sejours (client_id, nbre_nuit, nbre_adulte, nbre_enfant, wifi, visite_zoo, type_chambre, arrive_timestamp) VALUES (:client_id, :nbre_nuit, :nbre_adulte, :nbre_enfant, :wifi, :visite_zoo, :type_chambre, :arrive_timestamp)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":client_id",$client_id);
    $stmt->bindValue(":nbre_nuit",$nbrNuit);
    $stmt->bindValue(":nbre_adulte",$nbrAdulte);
    $stmt->bindValue(":nbre_enfant",$nbrEnfant);
    $stmt->bindValue(":wifi",$wifi);
    $stmt->bindValue(":visite_zoo",$visiteZoo);
    $stmt->bindValue(":type_chambre",$typeChambre);
    $stmt->bindValue(":arrive_timestamp",$date["timestamp"]);
    $stmt->execute();


    $satisf = [1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,4,4,4];
    shuffle($satisf);
    $n = rand(0,21);
    $chambre = $satisf[$n];
    $n = rand(0,21);
    $restauration = $satisf[$n];
    $n = rand(0,21);
    $bar = $satisf[$n];
    $n = rand(0,21);
    $accueil = $satisf[$n];
    $n = rand(0,21);
    $environnement = $satisf[$n];
    $n = rand(0,21);
    $rapport = $satisf[$n];
    $n = rand(0,21);
    $resto_amabilite = $satisf[$n];
    $n = rand(0,21);
    $resto_service = $satisf[$n];
    $n = rand(0,21);
    $resto_diversite = $satisf[$n];
    $n = rand(0,21);
    $resto_plats = $satisf[$n];
    $n = rand(0,21);
    $resto_vins = $satisf[$n];
    $n = rand(0,21);
    $resto_prix = $satisf[$n];
    $n = rand(0,21);
    $spa = $satisf[$n];
    $n = rand(0,21);
    $revenir = $satisf[$n];
    $n = rand(0,21);
    $recommander = $satisf[$n];
    $n = rand(0,21);
    $globalement = $satisf[$n];
    $prix = rand(1,3);


    // insert satisfaction
    $sql="INSERT INTO satisfaction (chambres, restauration, bar, accueil, environnement, rapport, resto_amabilite, resto_service, resto_diversite, resto_plats, resto_vins, resto_prix, spa, revenir, recommander, prix, client_id, globalement) VALUES (:chambres, :restauration, :bar, :accueil, :environnement, :rapport, :resto_amabilite, :resto_service, :resto_diversite, :resto_plats, :resto_vins, :resto_prix, :spa, :revenir, :recommander, :prix, :client_id, :globalement)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":chambres",$chambre);
    $stmt->bindValue(":restauration",$restauration );
    $stmt->bindValue(":bar",$bar);
    $stmt->bindValue(":accueil",$accueil);
    $stmt->bindValue(":environnement",$environnement);
    $stmt->bindValue(":rapport",$rapport);
    $stmt->bindValue(":resto_amabilite",$resto_amabilite);
    $stmt->bindValue(":resto_service",$resto_service);
    $stmt->bindValue(":resto_diversite",$resto_diversite);
    $stmt->bindValue(":resto_plats",$resto_plats);
    $stmt->bindValue(":resto_vins",$resto_vins);
    $stmt->bindValue(":resto_prix",$resto_prix);
    $stmt->bindValue(":spa",$spa);
    $stmt->bindValue(":revenir",$revenir);
    $stmt->bindValue(":recommander",$recommander);
    $stmt->bindValue(":prix",$prix);
    $stmt->bindValue(":client_id",$client_id);
    $stmt->bindValue(":globalement",$globalement);
    $stmt->execute();


    // insert connaissance/custom
    $sql="INSERT INTO client_connaissance_type (client_id, type_id) VALUES (:client_id, :type_id)";


    $q1_1 = rand(0,1);
    $q1_2 = rand(0,1);
    $q1_3 = rand(0,1);
    $q1_4 = rand(0,1);
    $q1_5 = rand(0,1);
    $q1_6 = rand(0,1);
    $q1_7 = rand(0,1);
    $q1_8 = rand(0,1);
    $q1_9 = rand(0,1);
    $q1_10 = rand(0,1);
    $q1_11 = rand(0,1);
    $q1_12 = "lorem ipsum";

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
            $sqlc = "INSERT INTO connaissance_types_custom (name, client_id) VALUES (:name, :client_id)";
            $stmtc = $pdo->prepare($sqlc);
            $stmtc->bindValue(":name", $q1_12);
            $stmtc->bindValue(":client_id", $client_id);
            $stmtc->execute();
        }
    }



}

ini_set("max_execution_time", 0);
for($i=0; $i<2000; $i++){
    create();
}