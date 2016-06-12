<?php

namespace MyCodeLab\Routing;

use Closure;
use MyCodeLab\Http\{Request, Url};

/**
 * Translates a URL into an application action.
 */
class Route
{
  /**
   * @var string
   */
  protected $pattern;
  
  /** 
   * @var Closure
   */
  protected $action;
  
  /**
   * @param string  $pattern
   * @param Closure $action
   */
  public function __construct($pattern, Closure $action)
  {
    $this->pattern = $pattern;
    $this->action  = $action->bindTo($this);
  }
  
  /**
   * @param MyCodeLab\Http\Url
   * 
   * @return bool
   */
  public function matches(Url $url)
  {
    return preg_match($this->pattern, $url->path());
  }
  
  
  public function dispatch(Request $request)
  {
    return call_user_func_array($this->action, [$request]);
  }
  
}