<?php

switch(ENV)
{
	case 'dev':
	case 'stage':
		error_reporting(E_ALL);
		ini_set('display_errors',1);
	break;
	case 'production':
		error_reporting(0);
		ini_set('display_errors',0);
	break;	
}

// Test DB connection
