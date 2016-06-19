<?php

use MyCodeLab\Dependency\Registry;
use MyCodeLab\Database\Connection;
use MyCodeLab\View\{Page, View};
use MyPhpWebsiteUserAuth\{PostRepository, PostDataGateway};

$registry = new Registry();


// Database
// ======================================================================d=====

$registry->bind('Connection', function ($args) {
  return new Connection(
    DB_NAME, 
    DB_USERNAME, 
    DB_PASSWORD, 
    DB_HOST,
    DB_DRIVER
  );
});


// View
// ============================================================================

$registry->bind('Page', function ($args) {
  $page   = new Page('layout', $args['title']);
  $header = (new View('header'))->set('title', $args['title']);
  $footer = new View('footer');
  
  $page->attachChild('header', $header)
       ->attachChild('footer', $footer);
  
  return $page;
});


// Model
// ============================================================================

$registry->bind('PostRepository', function ($args) {
  return new PostRepository(
    new PostDataGateway(
      $this->load('Connection')
    )
  );
});

return $registry;
