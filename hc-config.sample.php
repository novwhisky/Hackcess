<?php
define("DB_HOST",'');
define("DB_USER",'');
define("DB_PASS",'');
define("DB_SCHEMA",'');

// Don't change below settings unless you know what you're doing.
define("ENV",'dev');
define("DS",DIRECTORY_SEPARATOR);
define("APPROOT",realpath('.').DS);
define("HCCORE",APPROOT.'hc-core'.DS);
define("HCCONTROLLERS",APPROOT.'hc-controllers'.DS);
define("HCMODELS",APPROOT.'hc-models'.DS);

// After all configuration is complete
require_once HCCORE.'hc-env.php';
require_once HCCORE.'hc-loader.php';