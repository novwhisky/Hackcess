<?php
/*
 *
 * PHP Shell commands
 * exec() 		returns array of lines
 * shell_exec() returns one long string
 *
 *          field         allowed values
 *          -----         --------------
 *          minute        0-59
 *          hour          0-23
 *          day of month  1-31
 *          month         1-12 (or names, see below)
 *          day of week   0-7 (0 or 7 is Sun, or use names)
 *
 *		    A field may be an asterisk (*), which always stands for ``first-last''.
 */
class Cron {
	public $_user;
	public $_jobs;
	
	public function __construct()
	{
		$this->_user = trim(shell_exec('whoami'));
	}
	
	public function read()
	{
		// Loads crontab into array $this->_jobs
		$this->_jobs = array();
		exec('crontab -l 2>&1', $output);
		if($output[0] == "no crontab for ".$this->_user)
		{
			return false;
		}else{
			foreach($output as $lineK => $lineV)
			{
				if(preg_match("/\s?#/", $lineV))	unset($output[$lineK]);
			}
			
			$this->_jobs = array_values($output);
			return $this->_jobs;
		}
	}
	
	public function write($entries = array())
	{
		// This command completely overwrites user's crontab, be careful
		shell_exec("echo \"".implode("\n", $entries)."\" | crontab >/dev/null 2>&1");
	}
	
	public function append($entry)
	{
		// Add entry to end of crontab
		$entries = $this->read();
		if($entries !== false)
		{
			$this->write(array_merge($this->_jobs, array($entry)));
		}else{
			$this->write(array($entry));
		}
	}
	
	public function remove($entry)
	{
		// Removes matching entries
		$entries = $this->read();
		if($entries !== false){
			$keys = array_keys($entries, $entry);
			foreach($keys as $key)
			{
				unset($entries[$key]);
			}
			$this->write(array_values($entries));
		}
	}
	
	public function clear()
	{
		// Clears entire crontab
		$this->_jobs = array();
		return !! shell_exec('crontab -r >/dev/null 2>&1');
	}
	
}