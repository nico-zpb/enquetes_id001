<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 22/04/14
 * Time: 14:15
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

include_once "../../../php/functions.php";

if(!isPost() && !isAjax() || !postExists("form_excel_range") ){
    header("Location: /index.php");
    die();
}



$formDatas = getPost("form_excel_range");

header("Content-Type: appliaction/json");
//echo json_encode(["link"=>"", "error"=>true, "errorMsg"=>"Une erreur est survenue. Désolé pour ce désagrément."]);
echo json_encode(["link"=>"/survey/downloads/balbal.zip", "error"=>false,]);
die();