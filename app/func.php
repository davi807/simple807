<?php
/* More functions for app */
function mklink($str="",$full=false){
  if($full)
    $ht = ((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!='off')?'https':'http').'://'.$_SERVER['HTTP_HOST'];
  else
    $ht = '';
  return $ht.ROOT_ADDR.$str;
}

function to_page($addr,$exit=true){
  header('Location: '.$addr);
  if($exit) exit;
}

function mkdir_all($addr){
  if(!is_string($addr) || is_dir($addr))
    return false;
  return mkdir($addr,0777,true);
}

function Import($file,$once=true,$require=false){
	$get = IMPORT.$file.'.php';
	if(!file_exists($get))
		trigger_error('File "'.$get.'" not found');
	$once = $once?'1':'0';
	$require = $require?'1':'0';
	switch($once.$require):
		case '10': return include_once($get);
		case '11': return require_once($get);
		case '00': return include($get);
		case '01': return require($get);
	endswitch;
}