<?php

namespace MyCodeLab\Dependency;

use Closure;
use MyCodeLab\System\Object;
use MyCodeLab\System\NotFoundException;

/**
 * Represents a component binding before being resolved.
 */
class Binding extends Object
{
  /**
   * @var string
   */
  protected $name;

  /**
   * @var Closure Will eventually support string and array resolution.
   */
  protected $definition;

  /**
   * @var mixed[]
   */
  protected $parameters;

  public function __construct($name, $definition)
  {
    $this->name       = $name;
    $this->definition = $definition;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $thid->name;
  }

  /**
   * @return string|array|Closure
   */
  public function getDefinition()
  {
    return $this->definition;
  }

  /**
   * @throws NotFoundException if component cannot be resolved.
   * @return mixed
   */
  public function forge()
  {
    try {
      return $this->definition();
    } catch (Exception $e) {
      throw new NotFoundException("Component $this->name could not be resolved.", 0, $e); 
    } 
  }

}