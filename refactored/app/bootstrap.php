<?php

use MyCodeLab\Application;

// Define configuration constants
// ============================================================================

require_once 'config.php';


// Register class libraries for autoloading
// ============================================================================

require_once 'autoload.php';


// Register components
// ============================================================================

$registry = require_once 'components.php';


// Define valid URL routes
// ============================================================================

$map = require_once 'routes.php';

$app = new Application($map, $registry);

return $app;