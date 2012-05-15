<?php


class Dashboard extends Controller{
	
	public function __construct($data)
	{
		parent::__construct();
		echo "<h2>DASHBOARD</h2>";
		var_dump($data);
	}
}