<?php

function src($str,$k='"'){
  return "src=$k".mklink(PUB.$str)."$k";
}
function href($str,$k='"',$pub=false){
  $str = ($pub?PUB:"").$str; 
  if($k===0)$k='"';
  return "href=$k".mklink($str)."$k"; 
}
function action($str,$k='"'){
  return "action=$k".mklink($str)."$k";
}