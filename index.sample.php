<?php

require_once 'ppCfg.php';
require_once 'paypal.class.php';

// API Credentials generated here (Option 2): https://www.paypal.com/cgi-bin/customerprofileweb?cmd=_profile-api-access
$pp = new Paypal('API_USER','API_PASSWORD','API_SIGNATURE');