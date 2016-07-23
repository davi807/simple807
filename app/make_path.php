<?php
function make_valid_path(){
  if(IS_POST)
    return false;
  
  $dir = false;
  $addr = $_SERVER["REQUEST_URI"];
  $ptr = urldecode($_SERVER["REQUEST_URI"]);
  $st = strrpos($ptr,'[');
  $en = strrpos($ptr,']');
  if($st!==false && $en!==false && $st < $en ):
    $abs = substr($ptr,$st+1,$en-$st-1);
    $abs = $abs;
  endif;
  $req = ROOT_ADDR; 
  if(isset($abs)):
    $req.=$abs;
    $dir = true;
    if(isset($_GET) && !empty($_GET)):
      $qst = "";
      foreach($_GET as $g)
        $qst.= "/".$g;
      if($qst!='/'){
        $req.=$qst;
        $dir = true;
      }
    endif;
  endif;
  

  if($dir){
    header("Location: $req");
    exit(-2);
  }
}

function path_to_array($level = 0){
  $uri = $_SERVER["REQUEST_URI"];
  $fname = str_replace($_SERVER["DOCUMENT_ROOT"],"",$_SERVER["SCRIPT_FILENAME"]);
  if(strpos(" ".$uri,$fname)==1):
    $uri = str_replace($fname,"",$uri);
  else:
    $fp = explode('/',$fname);
    $fp = end($fp);
    $fname = str_replace("\\",'/',$fname);
    $fname = str_replace($fp,"",$fname);
    if(strpos(" ".$uri,$fname)==1)
      if(strlen($fname)>1)
        $uri = str_replace($fname,"",$uri);
      else
        $uri = substr($uri,1);
  endif;
  $res = explode("/",urldecode($uri) );
  $res = array_filter($res);
  $path = array();
  foreach($res as $v){
    $path[] = $v;
  }
  if(IS_GET && count($path)>0 && !empty($_SERVER["QUERY_STRING"]) ){
    $s = count($path) - 1;
    $path[$s] = str_replace("?".$_SERVER["QUERY_STRING"],"",$path[$s]);
    if(strlen($path[$s])==0)
      unset($path[$s]);
  }
  if($level>0)
    $path = array_slice($path,$level);
  return $path;
}
/** **/
function get_path_info($path){
  $r = array("controller"=>null,
             "action"=>null,
             "params"=>0
            );
  if(!is_array($path))
    return $r;
  $size = count($path);
  if($size < 1)
    return $r;
  $r["controller"] = $path[0];
  if($size > 1)
    $r["action"] = $path[1];
  $r["params"] = $size - 2;
  return $r;
}

