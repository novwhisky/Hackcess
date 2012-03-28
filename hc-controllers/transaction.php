<?php


class Transaction extends Controller{
	
	public function __construct($data)
	{
		parent::__construct();
		echo "<h2>Transaction</h2>";
		var_dump($data);
	}
}
$user = new User($data);