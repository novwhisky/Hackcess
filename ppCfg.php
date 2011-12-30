<?php

// Current environment. 'live' or 'sandbox'
define("ENV",'live');

// API version. Required by paypal for all requests
define("API_VER",'84.0');


switch(ENV)
{
	case 'sandbox':
		error_reporting(E_ALL);
		ini_set('display_errors',1);
		define("API",'https://api-3t.sandbox.paypal.com/nvp');
	break;
	case 'live':
		error_reporting(0);
		ini_set('display_errors',0);
		define("API",'https://api-3t.paypal.com/nvp');
	break;	
}