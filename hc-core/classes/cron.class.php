<?php
/*
 * http://stackoverflow.com/questions/4421020/use-php-to-create-edit-and-delete-crontab-jobs
 *
 *
 *
 */
class Cron {
	public $_cron_user;
	public $_cron_jobs;
	
	public function __construct()
	{
		$this->_cron_user = trim(shell_exec('whoami'));
	}
	
	public function crontab_read()
	{
		exec('crontab -l 2>&1', $output);
		foreach($output as $lineK => $lineV)
		{
			if(preg_match("/\s?#/",$lineV))	unset($output[$lineK]);
		}
		
		if($output[0] == "no crontab for ".$this->_cron_user)
		{
			return false;
		}else{
			$this->_cron_jobs = array_values($output);
			return $this->_cron_jobs;
		}
	}
	
	public function crontab_write($entries = array())
	{
		
	}
	
	public function crontab_append($entry)
	{
		
	}
	
	public function crontab_remove()
	{
		
	}
	
	public function crontab_clear()
	{
		$this->_cron_jobs = array();
		return !! exec('crontab -r');
	}
	
}