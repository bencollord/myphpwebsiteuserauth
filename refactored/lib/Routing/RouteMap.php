<?php

namespace MyCodeLab\Routing;

use MyCodeLab\Http\Url;
use MyCodeLab\Routing\Exceptions\RouteNotFoundException;

class RouteMap
{ 
  /**
   * @var array
   */
  protected $routes;

  /**
   * @param  string  $template The pattern the URL will be mapped to.
   * @param  Closure $action   The function to be executed upon a match.
   *                                                             
   * @return $this
   */
  public function register($template, $action)
  {
    $pattern = '~' . str_replace('/', '\\/', $template) . '$~';
    $this->routes[] = new Route($pattern, $action);

    return $this;
  }

  /**
   * Compares a URL against registered routes for a match.
   * 
   * @param  MyCodeLab\Http\Url $url
   *           
   * @throws RouteNotFoundException If a match is not found.
   *           
   * @return Route The matching route if found.
   */
  public function match(Url $url)
  {
    $matched = array_filter($this->routes, function ($route) use ($url) {
      return (bool) $route->matches($url);
    });
    
    if (empty($matched)) {
      throw new RouteNotFoundException("No route found for $url");
    }
    
    return array_shift($matched);
  }

}