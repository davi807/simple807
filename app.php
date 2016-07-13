<?php
/* PHP framework by Davi807 */
require_once 'app/root.php';
if(!file_exists($controller)):
  to_page('[error/not_found]');
endif;
require $controller;
if(!function_exists($action)){
  $pathInfo['action'] = 'index';
  $action = $pathInfo['action'].'Action';
  if(!function_exists($action))
    to_page('[error/not_found]');
}
if(empty($params))
  $params = get_params($pathInfo,$path);
if(count($params)<action_param_size($action)):
  to_page('[error/params]');
endif;
call_user_func_array($action,$params);