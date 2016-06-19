<?php

namespace MyCodeLab\Dependency;

use Closure;
use MyCodeLab\System\NotFoundException;

/**
 * Represents a component binding before being resolved.
 */
class Binding
{
  /**
   * @var string
   */
  protected $name;

  /**
   * @var Closure Will eventually support string and array resolution.
   */
  protected $definition;

  public function __construct($name, $definition)
  {
    $this->name       = $name;
    $this->definition = $definition;
  }

  /**
   * @return string
   */
  public function name()
  {
    return $thid->name;
  }

  /**
   * @throws NotFoundException if component cannot be resolved.
   * @return mixed
   */
  public function forge(array $args = array())
  {
    try {
      $definition = $this->definition;
      return $definition($args);
    } catch (Exception $e) {
      throw new NotFoundException("Component $this->name could not be resolved.", 0, $e); 
    } 
  }

}