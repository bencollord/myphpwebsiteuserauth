<?php

// =============================================================================
// CONFIGURATION CONSTANTS
// -----------------------------------------------------------------------------

define('DS', DIRECTORY_SEPARATOR);


// File paths
// =============================================================================

define('ROOT',        dirname(dirname(__FILE__)) . DS);
define('DOMAIN_NAME', 'http://localhost/myphpwebsiteuserauth');
define('WEB_ROOT',    DOMAIN_NAME . '/public/');
define('VIEW_PATH',   ROOT . 'app' . DS . 'templates');
define('TPL_SUFFIX',  '.tpl.php');


// Database
// =============================================================================

define('DB_DRIVER',   'mysql');
define('DB_HOST',     'localhost');
define('DB_NAME',     'userauthdb');
define('DB_USERNAME', 'ben');
define('DB_PASSWORD', 'WEBd#7');
