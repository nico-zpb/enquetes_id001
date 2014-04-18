<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 18/04/14
 * Time: 10:22
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

defined("ROOT") || define("ROOT", realpath(dirname(__DIR__)));
defined("LIBS") || define("LIBS", ROOT . DIRECTORY_SEPARATOR . "libs");

function autoload($classname){

    if($classname[0] == "\\"){
        $classname = substr($classname, 1);
    }

    $path = LIBS . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, $classname) . ".php";

    include_once $path;
}

spl_autoload_register("autoload");

function isPost(){
    return strtolower($_SERVER["REQUEST_METHOD"]) === "post";
}

function isGet(){
    return strtolower($_SERVER["REQUEST_METHOD"]) === "get";
}

function isAjax(){
    return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) === "xmlhttprequest";
}

function isConnected(){
    return isset($_SESSION["user"]) && $_SESSION["user"] != null;
}

function postExists($key){
    return isset($_POST[$key]) && $_POST[$key] != null;
}

function getPost($key, $default=null){
    if(array_key_exists($key, $_POST)){
        return $_POST[$key];
    }

    return $default;
}