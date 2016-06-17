<?php

use MyCodeLab\Routing\RouteMap;
use MyCodeLab\Http\{Request, Response};
use MyPhpWebsiteUserAuth\Model\Post;

$map = new RouteMap();

$map->register('/', function (Request $request, Response $response) {
  $posts = Post::loadAll('public');

  ob_start();
  
  foreach ($posts as $post) {
    echo '<br />' . 
         $post->getDetails() . '<br />' . 
         $post->getPostTime()->format(DateTime::W3C) . '<br />'; 
  }
  
  $content = ob_get_clean();

  $response->write('Home route works');
  $response->write("\n \n $content");

  return $response;
});

$map->register('/add', function (Request $request, Response $response) {
  $response->write('Add route works!');

  return $response;
});

$map->register('/edit', function (Request $request, Response $response) {
  $response->write('Edit route works!');

  return $response;
});

$map->register('/delete', function (Request $request, Response $response) {
  $response->write('Delete route works!');

  return $response;
});

$map->register('/login', function (Request $request, Response $response) {
  $response->write('Login route works!');

  return $response;
});

$map->register('/logout', function (Request $request, Response $response) {
  $response->write('Logout route works!');

  return $response;
});

$map->register('/register', function (Request $request, Response $response) {
  $response->write('Register route works!');

  return $response;
});
