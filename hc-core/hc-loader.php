<?php

class Controller{
	
	private $_req;
	private $_ns;
	private $_auth;
	
	public function __construct()
	{
		$this->_req = $_SERVER['REQUEST_URI'];
		$this->_ns  = "Hackcess.";
		$this->_auth = $this->check_auth();
		$this->parseRequest();
	}
	
	private function check_auth()
	{
		session_start();
		if(isset($_SESSION[$this->_ns.'auth']) && $_SESSION[$this->_ns.'auth'] == true)
		{
			return true;
		}else{
			return false;
		}
	}
	
	private function parseRequest()
	{
		$reqArr = explode('/',$this->_req);
		array_shift($reqArr);
		var_dump($reqArr);
	}
	
	private function loadView($name)
	{
		include_once HCTEMPLATES.$name.'.php';
	}
	
}

$ctlr = new Controller();