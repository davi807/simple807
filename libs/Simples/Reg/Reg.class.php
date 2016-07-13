<?php

//Super static variables by Davi807


mkdir_all(LIBDATA."Reg");
define("__REG_FILES_DIR",LIBDATA.'Reg/');  

class Reg{
  // file + class + function + type + key //
  static private $dir=__REG_FILES_DIR ;
  
  static function set($k,$v,$ex=8){
    $ex = (int)$ex;
    if($ex<=time() && $ex!==8)
      return false;
    $k = (string)$k;
    if(strlen($k)==0)
      return false;
    $from = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
    $str = print_r($from[1],true);
    $str .= $k;
    $res = $ex."@@".serialize($v);
    $str = md5($str);
    file_put_contents(self::$dir.$str,$res);
    return true;
  }
  
  static function get($k){ 
    $k = (string)$k;
    if(strlen($k)==0)
      return null;
    $from = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
    $str = print_r($from[1],true);
    $str .= $k;
    $str = md5($str);
    if(!file_exists(self::$dir.$str))
      return null;
    sscanf(
      file_get_contents(self::$dir.$str),
      "%d@@%s", $ex, $data 
    );
    if($ex<time() && $ex!==8){
      unlink(self::$dir.$str);
      return null;
    }
    return unserialize($data);
  }
  
  static function delete($k){
    $k = (string)$k;
    if(strlen($k)==0)
      return false;
    $from = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2);
    $str = print_r($from[1],true);
    $str .= $k;
    $str = md5($str);
    if(file_exists(self::$dir.$str))
      unlink(self::$dir.$str);
    return true;
  }
  
}