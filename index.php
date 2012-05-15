<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
//if(!include_once 'hc-config.php') die("<h1>Missing hc-config.php</h1><p>Hackcess can't work without a file named hc-config.php that should be located in the root of this install.</p>");

include_once "hc-core/classes/cron.class.php";

$cron = new Cron();
echo var_dump($cron->crontab_read());