<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 08:54
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
include_once "../../../datas/all.php";
include_once "../../../php/functions.php";
//TODO get year ( form on front page .....)
$annee = 2014; //provisoire
$monthStart = 1;
$dateStart = DateTime::createFromFormat("j-n-Y", "1-".$monthStart."-".$annee);

// aujourd'hui
$dateForToday = new DateTime();
// mois actuel
$monthEnd = $dateForToday->format("n");

if($debug){
    $monthEnd = 12;
}


$tmpDateEnd = DateTime::createFromFormat("j-n-Y", "1-" . $monthEnd . "-" . $annee);
// nombre de jours dans le mois actuel
$lastDayOfMonthEnd = $tmpDateEnd->format("t");
// datetime du dernier jour du mois actuel
$dateEnd = DateTime::createFromFormat("j-n-Y", $lastDayOfMonthEnd . "-" . $monthEnd . "-" .$annee);

// recup des timestamps
$dateStartTs = $dateStart->getTimestamp();
$dateEndTs = $dateEnd->getTimestamp();

include_once "../../../php/enquete-connexion.php";
$numEntry = 0;

// verif il y a t-il des enregistrements pour la periode ?
$sql = "SELECT COUNT(*) as num FROM clients WHERE arrive_timestamp>=:datestartts AND arrive_timestamp<=:dateendts";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":datestartts", $dateStartTs);
$stmt->bindValue(":dateendts", $dateEndTs);
$stmt->execute();
$numEntry = $stmt->fetch()["num"];
if(!$numEntry){
    die("no clients"); //TODO revoit sur page principale en cas de 0 entry
    /*setFlash("Il n'y a pas de résultats sur la période demandée.");
    header("Location: /survey/to-web.php");
    die();*/
}

$clientsByMonth = [];
$numEntryByMonth = [];
$numEntriesTotal = 0;

$sql = "SELECT * FROM clients WHERE arrive_annee=:annee AND arrive_mois=:mois";
$stmt = $pdo->prepare($sql);
for ($i = $monthStart; $i < $monthEnd + 1; $i++) {

    $stmt->bindValue(":annee", $annee);
    $stmt->bindValue(":mois", $i);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (!$result) {
        $ClientsByMonth[$datas_mois[$i - 1]] = [];
        $numEntryByMonth[$datas_mois[$i - 1]] = 0;
    }
    $count = count($result);
    $ClientsByMonth[$datas_mois[$i - 1]] = $result;
    $numEntryByMonth[$datas_mois[$i - 1]] = $count;
    $numEntriesTotal += $count;
}

/////////// connaissance /////////
function getEmptyConnaissanceArr()
{
    return [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
}

$sql = "SELECT type_id FROM client_connaissance_type WHERE client_id=:id";
$stmt = $pdo->prepare($sql);

$connaissanceByMonth = [];
$connaissanceNumByMonth = [];
$connaissancePercentByMonth = [];
$connaissanceTotal = getEmptyConnaissanceArr();
$connaissanceEntries = 0;

foreach ($ClientsByMonth as $monthShortName => $clientsInMonth) {
    $connaissanceByMonth[$monthShortName] = getEmptyConnaissanceArr();
    $connaissanceNumByMonth[$monthShortName] = 0;

    foreach ($clientsInMonth as $k => $client) {
        $stmt->bindValue(":id", $client["id"]);
        $stmt->execute();
        $tmp = $stmt->fetchAll();
        if ($tmp) {
            foreach ($tmp as $l => $t) {
                if($t["type_id"]>0){
                    $connaissanceByMonth[$monthShortName][$t["type_id"] - 1]++;
                    $connaissanceTotal[$t["type_id"] - 1]++;
                    $connaissanceEntries++;
                }
            }
        }
    }

    for ($i = 0; $i < count($connaissanceTotal); $i++) {
        $connaissanceNumByMonth[$monthShortName] += $connaissanceByMonth[$monthShortName][$i];
    }

    $all = $connaissanceNumByMonth[$monthShortName];

    $connaissancePercentByMonth[$monthShortName] = array_map(function ($it) use ($all) {
        return round(($it / $all) * 100);
    }, $connaissanceByMonth[$monthShortName]);

}

$connaissancePercentTotal = array_map(function ($it) use ($connaissanceEntries) {
    return round(($it / $connaissanceEntries) * 100);
}, $connaissanceTotal);




































require_once(LIBS . DIRECTORY_SEPARATOR . "html2pdf.class.php");




ob_start();
    include(dirname(__FILE__)."/page_01.php");
    include(dirname(__FILE__)."/page_02.php"); /* sommaire */
    include(dirname(__FILE__)."/page_03.php"); /* nombre de questionnaires */
    include(dirname(__FILE__)."/page_04.php");
    include(dirname(__FILE__)."/page_05.php");
    include(dirname(__FILE__)."/page_06.php"); /* mensuel - general - origine de la connaissance de l'hotel */
    include(dirname(__FILE__)."/page_07.php"); /* region d'habitation zone d'attraction */
    include(dirname(__FILE__)."/page_08.php"); /* mensuel - zone - charts - origine de la connaissance de l'hotel */
    include(dirname(__FILE__)."/page_09.php"); /* mensuel - zone - origine de la connaissance de l'hotel */
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
