<?php

require_once 'ppCfg.php';
require_once 'paypal.class.php';

$pp = new Paypal('API_USER','API_PASSWORD','API_SIGNATURE');

$res = $pp->api('TransactionSearch',array('STARTDATE'=>'2011-11-11 09:00:00'));

var_dump($res);