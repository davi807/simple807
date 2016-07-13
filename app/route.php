<?php
require_once "make_path.php";
make_valid_path();
require_once "get_params.php";
$path = path_to_array();
$pathInfo = get_path_info($path);
/*===============================*/
if(!$pathInfo['controller'])
  $pathInfo['controller'] = "index";

$controller = CTRL.$pathInfo['controller'].'_controller.php';

if(!file_exists($controller)){
  if($pathInfo['controller']=="error"){
    http_response_code(404);
    echo ' '; exit;
  }
  $pathInfo['controller'] = "index";
  $controller = CTRL.$pathInfo['controller'].'_controller.php';
}

if($pathInfo['controller'] == 'index'){
  if(!empty($path[0]))
    $pathInfo['action'] = $path[0];
}
/*===============================*/
if(!$pathInfo['action'])
  $pathInfo['action'] = "index";
$action = $pathInfo['action'].'Action';