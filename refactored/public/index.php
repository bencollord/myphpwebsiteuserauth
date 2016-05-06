<?php

use MyCodeLab\Kernel;
use MyCodeLab\Http\{Request, Response};
use MyCodeLab\System\NotFoundException;

use MyCodeLab\Routing\RouteMap;

require_once '../app/bootstrap.php';


$message  = '';
$request  = Request::capture();
$kernel   = new Kernel($map);
$response = $kernel->run($request);

ob_start();

include 'view.tpl';

$output = ob_get_clean();

$output .= $message;

$response->write($output);
$response->send();

