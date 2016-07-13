<?php

class MyDB_SQLBox{
	protected $sql = [];
	protected $sql_noarg = [];
	protected $db;
	
	function __construct(MyDB $db=null){
		if($db)
			$this->db = $db;
		else
			$this->db = MyDB::init();
	}

	function __call($name,$arg){
		if(isset($arg[0]) && is_array($arg[0]))
			$arg = $arg[0];
		if(isset($this->sql[$name]))
			return $this->db->loadString($this->sql[$name])
							->run($arg)->get();
		else
			throw new Exception("'$name' not found", 1);
			
	}

	function __set($name,$arg){
		if(!is_array($arg))
			$arg = [$arg];
		if(isset($this->sql[$name]))
			$this->db->loadString($this->sql[$name])
					 ->run($arg)->get();
	}

	function __get($name){
		if(isset($this->sql_noarg[$name]))
			$res = $this->db->query($this->sql_noarg[$name],PDO::FETCH_ASSOC);
			return $res->fetchAll(PDO::FETCH_ASSOC);
	}

}