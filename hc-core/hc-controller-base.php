<?php

/*
 *
 *
 *		THIS IS A BASE CLASS, NOT TO BE INITIALIZED DIRECTLY
 *
 *
 */
 
abstract class Controller{
	
	private $_req;
	private $_ns;
	private $_auth;
	
	public function __construct()
	{
		$this->_req = $_SERVER['REQUEST_URI'];
		$this->_ns  = "Hackcess.";
		$this->_auth = $this->checkAuth();
		$this->parseRequest();
	}
	
	private function checkAuth()
	{
		if(!isset($_SESSION)) session_start();
		if(isset($_SESSION[$this->_ns.'auth']) && $_SESSION[$this->_ns.'auth'] == true)
		{
			return true;
		}else{
			return false;
		}
	}
	
	private function parseRequest()
	{
		$reqArr = preg_replace('/[^a-zA-Z0-9\/]+/','-',$this->_req);
		$reqArr = explode('/',$reqArr);
		array_shift($reqArr);
	}
	
}