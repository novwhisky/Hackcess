<?php

class Loader{
	
	private $_req;
	private $_ns;
	private $_auth;
	public 	$controller;
	
	public function __construct()
	{
		$this->_req = preg_replace('/'.addslashes(WEBROOT).'/','',$_SERVER['REQUEST_URI']);
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
		$path = HCCONTROLLERS.$name.'.php';
		if(class_exists($name))
		{
			$controller = new $name($data);
		}else if($this->_req == WEBROOT){
			$controller = new Dashboard($data);
		}else{
			//404
			header("HTTP/1.0 404 Not Found");
			echo "<h1>404</h1>".$this->_req."<hr/><p>You broke it!</p>";
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

function dirload($path){
	if ($handle = opendir(APPROOT.$path)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				include APPROOT.$path.DS.$entry;
			}
		}
		closedir($handle);
	}
}

dirload('hc-controllers');
//dirload('hc-models');
//dirload('hc-templates');

$loader = new Loader();