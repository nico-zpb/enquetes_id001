<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 18/04/14
 * Time: 10:40
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
$path = str_replace("\\", DIRECTORY_SEPARATOR, realpath(dirname(__FILE__)) . "/../db/");
try{
    $pdo = new PDO("sqlite:" . $path . "enquetes_hjdb.sqlite",null,null,[PDO::ATTR_PERSISTENT=>true]);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
