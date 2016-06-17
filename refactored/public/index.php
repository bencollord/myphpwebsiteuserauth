<?php

use MyCodeLab\Application;
use MyCodeLab\Http\{Request, Response};
use MyCodeLab\Routing\RouteMap;

require_once '../app/bootstrap.php';

$app      = new Application($map);
$request  = Request::capture();
$response = $app->run($request);

$response->send();

