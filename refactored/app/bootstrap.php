<?php

use MyCodeLab\System\ClassLibrary;
use MyCodeLab\Http\{Request, Response};
use MyCodeLab\Routing\{Route, RouteMap};


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

$map = new RouteMap();

$map->register('/', function (Request $request) {
  return (new Response())->write('Closure routing works!');
});

$map->register('/edit', function (Request $request) {
  return (new Response())->write('Route with a path works!');
});