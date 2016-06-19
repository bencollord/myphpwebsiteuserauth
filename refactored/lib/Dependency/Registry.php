<?php

namespace MyCodeLab\Dependency;

use Closure;
use MyCodeLab\System\NotFoundException;
use MyCodeLab\Dependency\Exceptions\UnresolvedComponentException;

/**
 * Dependency injection container.
 * 
 * Currently only supports binding via closures, 
 * but will eventually be extended. 
 * 
 * @todo: Add features:
 *        - Bind interfaces to implementations
 *        - Build from arrays
 *        - Define a factory method to replace constructor
 */
class Registry
{
  /**
   * @var Binding[] Component resolutions.
   */
  protected $definitions = array();
  
  /**
   * @var array Shared component instances.
   */
  protected $instances = array();

  public function bind($key, Closure $resolution, $shared = false)
  {
    // Make Registry available inside resolution closure.
    $resolution = $resolution->bindTo($this);
    $binding    = new Binding($key, $resolution);

    $this->definitions[$key] = compact('binding', 'shared');
    
    return $this;
  }

  public function load($key, $args = array())
  {
    if (array_key_exists($key, $this->instances)) {
      return $this->instances[$key];
    }
    if (!array_key_exists($key, $this->definitions)) {
      throw new UnresolvedComponentException("No component with name '$key' has been registered.");
    }
    
    $definition  = $this->definitions[$key];
    $instance    = $definition['binding']->forge($args);
    
    if ($definition['shared'] === true) {
      $this->instances[$key] = $instance;
    }
    
    return $instance;
  }

}