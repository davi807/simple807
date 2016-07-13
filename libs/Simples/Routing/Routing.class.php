<?php

class Routing{
  static private $routing_files;
  static private $ctrl_addr;
  static private $route_addr;
  
  static function setControllersDir($pttr){
    if(!is_string($pttr) || empty($pttr))
      throw new Excaption("Controllers default location incorrect");
    if(!is_dir($pttr))
      throw new Excaption("Controllers default folder not found");
    self::$ctrl_addr = $pttr;
    return true;
  }
  
  static function setRouteDir($str){
    if(is_string($str) && !empty($str))
      self::$route_addr = $str;
  }
  
  static private function setRouting($addr=""){
    if(!empty(self::$route_addr))
      $r_addr = self::$route_addr;
    else
      $r_addr = HEAP."Routing/";
    
    if(empty($addr))
      self::$routing_files[] = $r_addr."route.ini";
    else{
      $addr = $r_addr.$addr;
      self::$routing_files[] = $addr;
    }
    
    $last = self::$routing_files[(count(self::$routing_files)-1)];
    
    if(!file_exists($last) && $addr=="" && $r_addr == HEAP."Routing/"):
      mkdir_all(HEAP."Routing");
      file_put_contents($last,file_get_contents(__DIR__."/std.ini"));
      return (-1);
    endif;
    if(!file_exists($last))
      return (-2);
    return true;
  }
  
  static private function parseroute($nn){
    $ini = parse_ini_file($nn,true);
    $arr = array();
    foreach($ini as $p):
      $tp = array(
        "path"=>(string)$p['path'],
        "file"=>(string)$p['file']);
      $values = array();
      if(count($p)>2){
        foreach($p as $pk=>$pv){
          $n = null;
          if($pk{0}=="<" && $pk{strlen($pk)-1}==">")
            $n = substr($pk,1,strlen($pk)-2);
          if(!empty($n))
            $values[$n] = $pv;
        }
        if(!empty($values))
          $tp["values"] = $values;
        if(!empty($p["method"]))
          $tp["method"] = strtoupper($p["method"]);
        if(!empty($p['argv']))
          $tp["argv"] = explode('|',$p['argv']);
      }
      $arr[] = $tp;
    endforeach;
    return $arr;
  }
  
  static function start($s=""){
    global $pathInfo;
    global $ctrl_error;
    $ctrl_error = 0;
    if(!is_array($pathInfo))
      return false;
    $args = func_get_args();
    if(count($args)==0)
      $args[0] = "";
    if(is_array($args[0]))
      $args = $args[0];
    foreach($args as $v){
      $r = self::setRouting($v);
      if($r !== true)
        if($r == -1)
          throw new Exception("Go to '".HEAP."Routing/route.ini ' and set route settings");
        elseif($r == -2)
          throw new Exception("Route file '$v' not found");
        
    }
    $rules = array();
    foreach(self::$routing_files as $m){
      $rules = array_merge($rules,self::parseroute($m));
    }
    /**************************/

    $request = substr($_SERVER["REQUEST_URI"],strlen(ROOT_ADDR));
    
    $req_arr = explode("/",$request);
    
    $GLOBALS["params"] = array();
    
    if(!is_null(self::$ctrl_addr))
      $rdefdir = self::$ctrl_addr;
    else
      $rdefdir = "";
    foreach($rules as $r){
      if(isset($r['method']) && $r['method'] !== $_SERVER['REQUEST_METHOD'])
        continue;
      $ok = false;
      $r_a = explode("/",$r["path"]);
      if(count($r_a)!=count($req_arr))
        continue;
      $size = count($r_a);
      for($i=0;$i<$size;++$i):
        if($r_a[$i]!=$req_arr[$i]){
          if(strlen($r_a[$i]) ==0 ||$r_a[$i]{0} != "{" || $r_a[$i]{strlen($r_a[$i])-1} != "}"){
            $ok = false;
            break;
          }
          $c_val = substr($r_a[$i],1,strlen($r_a[$i])-2);
          
          if(isset($r["values"][$c_val])){
            if( !preg_match('/'.$r["values"][$c_val].'/', $req_arr[$i]) ){ 
              $ok = false;
              break;
            }
          }
          if(empty($c_val{0}))
            $c_val = "~";
          switch($c_val{0}){
            case "-" :
              break;
            case "+" : 
              $GLOBALS[substr($c_val,1)] = $req_arr[$i];
              break;
            default:
              $GLOBALS["params"][] = $req_arr[$i];
          }
        }
        if(isset($r['argv']))
          $GLOBALS["params"] = $r['argv']; 
        $ok = true;
      endfor;
      if(!$ok)
        $GLOBALS["params"] = array();
      else{
        $f = explode(":",$r["file"]);
        if(empty($f[1]) || empty($f[0]))
          throw new Exception("ini file is not correct near '{$r['file']}'");
        global $controller;
        $controller = $rdefdir.$f[0];
        global $action;
        $action = $f[1];
        break;
      }
    }
  }
}