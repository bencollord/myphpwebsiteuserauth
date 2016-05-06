<?php

namespace MyCodeLab\Dependency;

use Closure;
use MyCodeLab\System\{Object, NotFoundException};

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
class Registry extends Object
{
  /**
   * @var ComponentBinding[] Component resolutions.
   */
  protected $bindings;
  
  /**
   * @var array Shared component instances.
   */
  protected $instances;

  public function bind($key, Closure $resolution, $shared = false)
  {
    $binding = new ComponentBinding($key, $resolution);
    
    if ($shared === true) {
      $this->instances[$key] = $binding->forge();
    }

    $this->components[$key] = new ComponentBinding($key, $resolution);
    
    return $this;
  }

  public function load($key)
  {
    if (array_key_exists($key, $this->instances)) {
      return $this->instances[$key];
    }
    if (array_key_exists($key, $this->bindings)) {
      return $this->components[$key]->forge();
    }
    
    throw new UnresolvedComponentException("No component with name '$key' has been registered.");
  }

}