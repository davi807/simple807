<?php
/** DEFINES **/

define("APP","app/");
define("HEAP","src/"."heap/");
define("IMPORT","src/"."import/");
define("LIBDATA",HEAP."_libdata_/");

define("CTRL","src/controllers/");
define("MOD","src/models/");
define("TPL","src/templates/");
define("LIB","libs/");
define("PUB","public/");

define("IS_GET",($_SERVER["REQUEST_METHOD"]=="GET"));

define("IS_POST",($_SERVER["REQUEST_METHOD"]=="POST"));

define("ROOT_ADDR",call_user_func(
  function(){
  $req = str_replace($_SERVER['DOCUMENT_ROOT'],"",$_SERVER['SCRIPT_FILENAME']); 
  $f = substr($_SERVER['SCRIPT_FILENAME'],strrpos($_SERVER['SCRIPT_FILENAME'],'/')+1);
  $req = str_replace($f,"",$req);
  return $req;
}));