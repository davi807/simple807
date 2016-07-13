<?php
//MySQL DataBase class by davi807

class MyDB {
  
  static private $last=null;
  static private $conf_addr;
  private $qdir;
  private $ob;
  private $ptr;

  static function init(){
  	if(static::$last)
  		return static::$last;
  	else
  		return new MyDB;
  }

  private function setConfigFile($addr=""){ 
    if(isset(self::$conf_addr) && !empty(self::$conf_addr))
      return false;
    if($addr==""):
      self::$conf_addr = HEAP."MyDB/config.ini";
      mkdir_all(HEAP."MyDB"); 
      if(!file_exists(HEAP."MyDB/config.ini")){
        file_put_contents(HEAP."MyDB/config.ini",file_get_contents(__DIR__."/std.ini"));
        throw new Exception("Go to '".HEAP."MyDB/config.ini' and configurate your database settings");
      }
      return true;
    endif;
    if(is_string($addr) &&  !empty($addr))
      self::$conf_addr = $addr;
    else
      throw new Exception("Given address is not correct");
    return true;
  }

  private function parse(){
    $this->setConfigFile();
    $ini = parse_ini_file(self::$conf_addr,true);
    if(count($ini["MyDB Config"])>=3)
      return $ini;
    else
      return array();
  }

  function __construct(){
    $opt = func_num_args();
    if($opt==0){
      $con = "";
      $cache = true;
    }
    else{
      $opt = func_get_args();
      $con = (string)$opt[0];
    }
    $this->setConfigFile($con);
    $r = $this->parse();
    if(empty($r["MyDB Config"]) || empty($r["PDO Options"]))
      throw new Exception("MyDB config file error");
    $conf = $r["MyDB Config"];
    $pd   = $r["PDO Options"];
    
    $str = "mysql:host={$conf['host']};";
    foreach($pd as $k=>$v){
      $str.= "$k=$v;";
    }
    $str = substr( $str,0,strlen($str)-1);
    try{
      $this->ob = new PDO($str,$conf["username"],$conf["password"]);
    }
    catch(PDOException $e){
      throw new Exception("No database connection:",$e->getCode());
    }  
    if(isset($conf["query_dir"]))
      $this->setQueryDir($conf["query_dir"]);
    if(isset($cache))
    	static::$last = $this;
    return $this;
  }
  
  function  setQueryDir($str=""){
    if($str=="" && empty($this->qdir)):
      mkdir_all(HEAP."MyDB/");
      $this->qdir = HEAP."MyDB/";
      return true;
    else:
      if($str{strlen($str)-1} != '/')
        $str .= '/';
      $this->qdir = $str;
    endif;
  }
  
  function load($f,$arr = array()){
    if(empty($this->qdir))
      $this->setQueryDir();
    $q = file_get_contents($this->qdir.$f);
    $this->ptr = $this->ob->prepare($q,$arr);
    return $this;
  }

  function loadString($q,$arr = array()){
    $this->ptr = $this->ob->prepare($q,$arr);
    return $this;
  }

  function run($r=array()){
      $res = $this->ptr->execute($r);
      if(!$res)
        return $res;
      return $this;
  }

  function get($smt = PDO::FETCH_ASSOC){
    return $this->ptr->fetchAll($smt);
  }

  function __call($name,$args){
    if( is_callable(array($this->ob, $name)) ):
      echo 120;
      return call_user_func_array(array($this->ob,$name),$args);
    endif;
    if( is_callable(array($this->ptr, $name)) )
      return call_user_func_array(array($this->ptr,$name),$args);
    return false;
  }
}
