<?php

function get_params($info,$path){
  if(!is_array($info) ||
     !is_array($path) ||
    !isset($info['controller']) ||
    !isset($info['action'])  ||
    !isset($info['params'])
  )
    return array();
    
  $size = count($path);
  if($info['controller']!='index')
    $path = array_slice($path,1); 
  if($info['action']!='index')
    $path = array_slice($path,1);
  
  return $path;
}
/***********/
function action_param_size($action){
  $action = (string)$action;
  $reflect = new ReflectionFunction($action);
  return $reflect->getNumberOfRequiredParameters();
}