<?php

use MyCodeLab\Application\{Kernel, Controller};
use MyCodeLab\Dependency\Registry;
use MyCodeLab\Http\{Request, Response, Session, Url};
use MyCodeLab\Routing\{RouteMap, Factory as RouteFactory};
use MyCodeLab\Database\Connection;
use MyCodeLab\View\{View, Page};
use MyCodeLab\Auth\Authentication;
use MyPhpWebsiteUserAuth\Controller{PostsController, UsersController};
use MyPhpWebsiteUserAuth\Model\{Post, PostDataGateway};


$registry = new Registry();

$registry->bind('Kernel', function () { 
  return new Kernel([
    'root'        => '../' . __DIR__,                       // ROOT
    'environment' => 'dev',                                 // APP_ENV
    'domain'      => 'http:localhost/myphpwebsiteuserauth', // DOMAIN_NAME
    'debug'       => true,                                  // DEBUG
    'timezone'    => 'America/Boise'                        // TIMEZONE
  ]);
});

$registry->bind('Url', function () {
  $url  = DOMAIN_NAME . DS;
  $url .= $_GET['path'] ?? null;
  $url .= $_SERVER['QUERY_STRING'] ?? null;

  return new Url($url);
});

$registry->bind('Request', function () use ($registry) {  
  return Request::capture(
    $registry->load('url')
  );
}, true);

$registry->bind('Response', function () {
  return new Response();
}, true);

$registry->bind('Session', function () {
  return new Session();
}, true);

// @todo: one of these objects will need a reference to $registry
$registry->bind('RouteMap', function () {
  return new RouteMap(
    new RouteFactory()
  )
});

$registry->bind('Database', function () {
  return new Connection(DB_NAME, DB_USER, DB_PASS, DB_DRIVER, DB_HOST);
});

$registry->bind('View', function () {
  return new View();
});

$registry->bind('Page', function () {
  return new Page();
}, true);

$registry->bind('Auth', function () use ($registry) {
  return new Authentication(
    $registry->load('Request'),
    $registry->load('Session')
  );
});

$registry->bind('Controller', function () use ($registry) {
  $registry->load('request'),
  $registry->load('response'),
  $registry->load('session')
});

$registry->bind('PostsController', function () {
  // @todo: extend base Controller somehow
  $registry->load('auth')
});

$registry->bind('UsersController', function () {
  // @todo: extend base Controller somehow
  $registry->load('auth')
});