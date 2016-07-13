<?php

class Translate{
	protected $path;
	protected $pageName;
	protected $metaName = '__GLOBAL__';

	protected $language;
	protected $meta = [];
	protected $content = [];

	function __construct($lang,$page=null){
		$this->path = HEAP.'Translate/';
		$this->language = $lang;
		
		if(!is_dir($this->path))
			mkdir_all($this->path);

		if(is_dir($this->path.$lang))
			$this->path = $this->path.$lang.'/';
		else
			throw new Exception("Translate folder for '$lang' not found",1);

		$metaFile = $this->path.$this->metaName;
		if(file_exists($metaFile.'.ini'))
			$this->meta = parse_ini_file($metaFile.'.ini');
		elseif(file_exists($metaFile.'.php')){
			$this->meta = include($metaFile.'.php');
			if(!is_array($this->meta))
				throw new Exception($this->metaName." must return array, '".gettype($this->meta)."' returned", 2);
		}
		if($page)
			$this->getPage($page);
		return $this;
	}

	function getPage($page){
		$pageName = $page;
		$page = $this->path.$page; 
		if(file_exists($page.'.ini'))
			$this->content = parse_ini_file($page.'.ini');
		elseif(file_exists($page.'.php')){
			$this->content = include($page.'.php');
			if(!is_array($this->content))
				throw new Exception($page." must return array, '".gettype($this->meta)."' returned", 3);
		}else
			throw new Exception("Page '$pageName' not found in folder '".$this->language."'", 4);
		return $this;
	}

	function __get($row){
		if(isset($this->content[$row]))
			return $this->content[$row];
		elseif(isset($this->meta[$row]))
			return $this->meta[$row];
		else
			return '';
	}

	function getGlobal(){
		return $this->meta;
	}

	function getContent(){
		return $this->content;
	}	

	/*
	function Comape($a){
	
	}
	*/
}