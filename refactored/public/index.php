<?php

use MyCodeLab\Kernel;
use MyCodeLab\Http\{Request, Response};
use MyCodeLab\System\NotFoundException;

use MyCodeLab\Routing\RouteMap;

require_once '../app/bootstrap.php';

$request  = Request::capture();
$kernel   = new Kernel($map);
$response = $kernel->run($request);

$response->send();

