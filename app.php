<?php
/* PHP framework by Davi807 */
require_once 'app/root.php';

//Load controller file
require $controller;

//Is action exists
if(!function_exists($action)){
  $pathInfo['action'] = 'index';
  $action = $pathInfo['action'].'Action';
  if(!function_exists($action))
    to_page(mklink('error/not_found'));
}

//Get params
if(empty($params))
  $params = get_params($pathInfo,$path);
if(count($params)<action_param_size($action)):
  to_page(mklink('error/params'));
endif;

//Call action and bind params
call_user_func_array($action,$params);