<?php

use MyCodeLab\Http\{Request, Response};
use MyCodeLab\Routing\RouteMap;

$app = require_once '../app/bootstrap.php';

$request  = Request::capture();
$response = $app->run($request);

$response->send();

