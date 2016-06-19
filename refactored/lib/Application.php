<?php

namespace MyCodeLab;

use MyCodeLab\Http\{Request, Response};
use MyCodeLab\Dependency\Registry;
use MyCodeLab\Routing\RouteMap;
use MyCodeLab\Routing\Exceptions\RouteNotFoundException;
use MyCodeLab\System\Exceptions\NotFoundException;


class Application
{
  /**
   * @var MyCodeLab\Routing\RouteMap
   */
  protected $routeMap;
  
  /**
   * @var MyCodeLab\Dependency\Registry
   */
  protected $registry;
  
  /**
   * @var Closure[]
   */
  protected $before = array();
  
  /**
   * @var Closure[]
   */
  protected $after = array();
  
  public function __construct(RouteMap $routes, Registry $registry)
  {
    $this->routeMap = $routes;
    $this->registry = $registry;
  }
  
  public function beforeDispatch(Closure $callback) 
  {
    $this->before[] = $callback->bindTo($this);
  }
  
  public function afterDispatch(Closure $callback) 
  {
    $this->after[] = $callback->bindTo($this);
  }
  
  /**
   * @param  MyCodeLab\Http\Request $request
   * 
   * @return MyCodeLab\Http\Response
   */
  public function run(Request $request)
  {
    $this->runMiddlewareStack($this->before);
    
    $url = $request->url();
    
    try {
      $route    = $this->routeMap->match($url);
      $response = $route->dispatch($request);  
    } catch (RouteNotFoundException $e) {
      $response = new Response(404);
      $response->write("There's nothing here. Sorry!");
    }
    
    $this->runMiddlewareStack($this->after);
    
    return $response;
  }
  
  // Internal Methods
  // ==================================================
  
  protected function runMiddlewareStack($stack)
  {
    foreach ($stack as $callback) {
      $callback();
    }
  }

}