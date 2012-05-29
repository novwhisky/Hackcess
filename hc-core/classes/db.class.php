<?php
/**
 * Class DB
 * Singleton class instantiated by DB::getInstance();
 *
 */
class DB {
	private static $singleton;
	private	$dbh;
	private $dbParams = "%s:dbname=%s;host=%s;port=%s";
	
	private function __construct()
	{
		$this->db_config();
	}
	
	public static function getInstance()
	{
		if (!self::$singleton)
		{
			self::$singleton = new DB();
		}
	
		return self::$singleton;
	}
	
	private function db_config()
	{
		if(	getenv('HC_DB_TYPE'  ) && 
			getenv('HC_DB_HOST'  ) && 
			getenv('HC_DB_PORT'	 ) && 
			getenv('HC_DB_USER'  ) && 
			getenv('HC_DB_PASS'	 ) &&
			getenv('HC_DB_SCHEMA'))
		{
			$strProps = sprintf($this->dbParams, getenv('HC_DB_TYPE'), getenv('HC_DB_SCHEMA'), getenv('HC_DB_HOST'), getenv('HC_DB_PORT'));
			try{
				$this->dbh = new PDO($strProps, getenv('HC_DB_USER'), getenv('HC_DB_PASS'));
			}catch(PDOException $e){
				//echo $e->getMessage();
			}
		}else{
			throw new Exception("No database config found");
		}
	}
	
	// This method does not escape user input. Vulnerable to SQL injection
	public function query($query)
	{
		if(!empty($this->dbh))
		{
			try{
				$stmt = $this->dbh->query($query)->fetchAll();
				return $stmt;
			}catch(PDOException $e){
				//echo $e->getMessage();
				return false;
			}
		}
	}
	
	public function exec($query)
	{
		if($this->dbh->exec($query))
		{
			return true;
		}else{
			return false;
		}
	}
}