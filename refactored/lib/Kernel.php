<?php

namespace MyCodeLab;

use MyCodeLab\Http\{Request, Response};
use MyCodeLab\Routing\RouteMap;
use MyCodeLab\Routing\Exceptions\RouteNotFoundException;
use MyCodeLab\System\Exceptions\NotFoundException;

/**
 * Represents a web application.
 */
class Kernel
{
  /**
   * @var string Current deployment environment.
   */
  protected $environment;
  
  /**
   * @var string
   */
  protected $root;
  
  /**
   * @var MyCodeLab\Routing\RouteMap
   */
  protected $routeMap;
  
  public function __construct(RouteMap $routes)
  {
    $this->routeMap = $routes;
  }
  
  
  /**
   * @param  MyCodeLab\Http\Request $request
   * 
   * @return MyCodeLab\Http\Response
   */
  public function run(Request $request)
  {
    $url = $request->getUrl();
    try {
      $route    = $this->routeMap->match($url);
      $response = $route->dispatch($request);  
    } catch (RouteNotFoundException $e) {
      $response = new Response(404);
      $response->write("There's nothing here. Sorry!");
    }
    
    return $response;
  }

}