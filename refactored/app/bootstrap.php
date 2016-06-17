<?php

use MyCodeLab\System\ClassLibrary;


// Define configuration constants
// ============================================================================

require_once 'config.php';


// Register class libraries for autoloading
// ============================================================================

require_once '../lib/System/ClassLibrary.php';

$framework = new ClassLibrary('MyCodeLab', 'lib');
$appCode   = new ClassLibrary('MyPhpWebsiteUserAuth', 'app');

$framework->register();
$appCode->register();



// Define valid URL routes
// ============================================================================

require_once 'routes.php';