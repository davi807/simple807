<?php

spl_autoload_register(
  function ($cName){
  $folders = array(
              LIB."Simples/",
              LIB,
              MOD
            );
  $files = array(
              "$cName/$cName.class.php",
              "$cName/class.php",
              "$cName.class.php"
            );
  if(strpos($cName,'_')){
  	$sup = explode('_',$cName);
  	$sup = $sup[0];
  	$folders[] = LIB."Simples/$sup/";
  }
  foreach($files as $fi):
    foreach($folders as $fd){
      $c = $fd.$fi;
      if(file_exists($c)){
        require_once($c);
      }
    }
  endforeach;
});

if(file_exists('vendor/autoload.php'))
	include_once 'vendor/autoload.php';