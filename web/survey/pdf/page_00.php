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
require_once(LIBS . DIRECTORY_SEPARATOR . "html2pdf.class.php");
$annee = 2014;



ob_start();
    include(dirname(__FILE__)."/page_01.php");
    include(dirname(__FILE__)."/page_02.php"); /* sommaire */
    include(dirname(__FILE__)."/page_03.php"); /* nombre de questionnaires */
    include(dirname(__FILE__)."/page_04.php");
    include(dirname(__FILE__)."/page_05.php");
    include(dirname(__FILE__)."/page_06.php"); /* mensuel origine de la connaissance de l'hotel */
    include(dirname(__FILE__)."/page_07.php"); /* region d'habitation zone d'attraction */
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
