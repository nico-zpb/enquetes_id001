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


}


for($i=0; $i<2; $i++){
    create();
}