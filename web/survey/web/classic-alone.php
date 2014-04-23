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

include_once "../../../php/enquete-connexion.php";


$sql = "SELECT * FROM clients WHERE arrive_mois=:arrive_mois AND arrive_annee=:arrive_annee";
$clientStmt = $pdo->prepare($sql);
$clientStmt->bindValue(":arrive_mois", (int)$monthStart);
$clientStmt->bindValue(":arrive_annee", (int)$annee);
$clientStmt->execute();
$clientResult = $clientStmt->fetchAll();

if(!$clientResult){
    // pas de résultat pour cette entrée
}














