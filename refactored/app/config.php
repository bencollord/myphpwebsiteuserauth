<?php

// =============================================================================
// CONFIGURATION CONSTANTS
// -----------------------------------------------------------------------------

define('DS', DIRECTORY_SEPARATOR);


// Folder paths
// =============================================================================

define('ROOT',        dirname(dirname(__FILE__)) . DS);
define('WEB_ROOT',    ROOT . 'public' . DS);
define('DOMAIN_NAME', 'http://localhost/myphpwebsiteuserauth');


// Database
// =============================================================================

define('DB_DRIVER', 'mysql');
define('DB_HOST',   'localhost');
define('DB_NAME',   'userauthdb');
define('DB_USER',   'ben');
define('DB_PASS',   'WEBd#7');
