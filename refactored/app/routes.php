<?php

use MyCodeLab\Routing\RouteMap;
use MyCodeLab\Http\{Request, Response};
use MyCodeLab\Database\Connection;
use MyPhpWebsiteUserAuth\{Post, PostRepository, PostDataGateway, PostListView};

$map = new RouteMap();

$map->register('/', function (Request $request, Response $response) use ($registry) {
  $page       = $registry->load('Page', ['title' => 'Home Page']);
  $repository = $registry->load('PostRepository');
  $posts      = $repository->findPublic();
  $view       = new PostListView('posts/home', $posts);
  
  $page->attachChild('content', $view);
  $response->write($page->render());

  return $response;
});

$map->register('/add', function (Request $request, Response $response) use ($registry) {
  $repository = $registry->load('PostRepository');
  
  // New post code goes here
  
  $view = new View('posts/add');
  
  $response->write($view->render());

  return $response;
});

$map->register('/edit', function (Request $request, Response $response) use ($registry) {
  $repository = $registry->load('PostRepository');
  $post       = $repository->find(/*route id*/);
  
  // Edit post code goes here
  
  $view = new View('posts/edit');
  
  $response->write($view->render());

  return $response;
});

$map->register('/delete', function (Request $request, Response $response) use ($registry) {
  $repository = $registry->load('PostRepository');
  $post       = $repository->find(/*route id*/);
  
  // Delete post code goes here
  // Flash message goes here
  // Redirect

  return $response;
});

$map->register('/login', function (Request $request, Response $response) use ($registry) {
  $response->write('Login route works!');

  return $response;
});

$map->register('/login/form', function (Request $request, Response $response) use ($registry) {

  return $response;
});

$map->register('/logout', function (Request $request, Response $response) use ($registry) {
  $response->write('Logout route works!');

  return $response;
});

$map->register('/register', function (Request $request, Response $response) use ($registry) {
  $response->write('Register route works!');

  return $response;
});

$map->register('/register/form', function (Request $request, Response $response) use ($registry) {

  return $response;
});

return $map;
