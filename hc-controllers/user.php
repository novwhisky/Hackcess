<?php


class User extends Controller{
	
	public function __construct($data)
	{
		parent::__construct();
		echo "<h2>USERS</h2>";
		var_dump($data);
	}
}
$user = new User($data);