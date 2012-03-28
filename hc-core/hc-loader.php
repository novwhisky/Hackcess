<?php

class Loader{
	
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
	
	private function parseRequest()
	{
		$reqArr = preg_replace('/[^a-zA-Z0-9\/]+/','-',$this->_req);
		$reqArr = explode('/',$reqArr);
		array_shift($reqArr);
		$ctlr = array_shift($reqArr);
		$this->loadController($ctlr,$reqArr);
	}
	
	private function loadController($name,$data = array())
	{
		$ldr = $this;
		include_once HCCORE.'hc-controller-base.php';
		$path = HCCONTROLLERS.$name.'.php';
		if(file_exists($path))
		{
			include_once $path;
		}else{
			//404
			header("HTTP/1.0 404 Not Found");
			echo '<h1>404</h1><hr/><p>You broke it!</p>';		
		}
	}
	
	private function checkAuth()
	{
		session_start();
		if(isset($_SESSION[$this->_ns.'auth']) && $_SESSION[$this->_ns.'auth'] == true)
		{
			return true;
		}else{
			return false;
		}
	}

}

$loader = new Loader();