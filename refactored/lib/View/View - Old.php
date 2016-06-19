<?php

namespace MyCodeLab\View;

class View implements Renderable
{
  /**
   * No escaping
   */
  const ENCODE_RAW = 0;

  /**
   * Escape using htmlspecialchars
   */
  const ENCODE_SAFE = 1;

  /**
   * Encode using htmlentities
   */
  const ENCODE_STRICT = 2;

  /**
   * @var string  Path to template file.
   */
  protected $template;

  /**
   * @var mixed[] Views nested in this instance.
   */
  protected $children = array();

  /** 
   * @var mixed[] Variables that will be embedded into the rendered output.
   */
  protected $params = array();

  /**
   * @var int Class constant value defining how to escape output. 
   *          Default is the value of ENCODE_SAFE
   */
  protected $escapeMode = 1;

  
  /* ========================================= */
  /* ----------      Accessors      ---------- */
  /* ========================================= */

  public function getTemplate()
  {
    return $this->template;
  }

  public function setTemplate($template)
  {
    $path = $this->find($template);

    $this->template = $path;

    return $this;
  }

  /**
   * Set output HTML escaping. 
   * 
   * Can either take a class constant value or convert to it from a string.
   * 
   * @param  string|int $mode
   *           
   * @throws InvalidArgumentException if $mode does not evaluate to a valid mode.
   * 
   * @return $this
   */
  public function setEscapeMode($mode) {
    // Prevent uppercase letters from throwing error.
    $mode = strtolower($mode);

    if ($mode === 0 || $mode == 'raw') {
      $this->escapeMode = static::ENCODE_RAW;
    } elseif ($mode === 1 || $mode == 'safe') {
      $this->escapeMode = static::ENCODE_SAFE;
    } elseif ($mode === 2 || $mode == 'strict') {
      $this->escapeMode = static::ENCODE_STRICT;
    } else {
      throw new InvalidArgumentException("Invalid value set for ViewDataSet::escapeMode.");
    }

    return $this;
  }

  /**
   * Gets a value from the $params array.
   * 
   * @param string $name  The key in the array.
   *                                             
   * @return mixed|bool  The value from $params, or false if not found.
   */
  public function get($name)
  {
    if (array_key_exists($name, $this->params)) {
      return $this->params[$name];
    } else {
      return false;
    }
  }

  /**
   * Adds a value to the $params array.
   * 
   * @param string $name  The key the value will be indexed by.
   * 
   * @return $this
   */
  public function set($name, $value)
  {
    $this->params[$name] = $value;

    return $this;
  }

  /**
   * Adds a parameter by reference.
   * 
   * @param  string $name       The key the reference will be indexed by.
   * @param  mixed  &$reference A reference to an outside variable.
   *
   *  @return $this
   */
  public function bind($name, &$reference)
  {
    if (is_object($reference)) {
      $this->params[$name] = $reference;
    } else {
      $this->params[$name] =& $reference;
    }

    return $this;
  }

  /**
   * Adds a view to the $children array.
   * 
   * @param  string $name  The key the child will be indexed by.
   * @param  View   $child A fully instantiated View object.
   *                                                 
   * @return $this
   */
  public function attachChild($name, View $child)
  {
    $this->children[$name] = $child;

    return $this;
  }

  /**
   * Finds and immediately renders a view fron the template provided.
   * 
   * Acts as a shorthand method to be used within template files for quick
   * fetching and rendering of partial views or elemental template fragments.
   * 
   * @return string The rendered view output.
   */
  public function fetch($template, $params = array())
  {
    return (new self($template, $params))->render();
  }

  /**
   * Creates a new View instance and adds it to the $children array.
   * 
   * The new child view will be passed a copy of the parent view's data.
   * Since it is not passed by reference, a change made to a variable by 
   * the child will not affect the data of the parent.
   * 
   * @param string        $name     The key that will identify the child in 
   *                                the $children array.
   * @param string        $template The template identifier.
   * @param mixed[string] $params   Any additional data to be passed to the 
   *                                child in addition to parent data.
   *                                
   * @return $this
   */
  public function loadChild($name, $template, $params = array())
  {
    $data = array_merge($this->params, $params);

    $this->children[$name] = new self($template, $data);

    return $this;
  }

  /**
   * Renders the view to HTML.
   * 
   * Note: The variables stored in both $params and $children ARE extracted
   *       to the global scope using the flag EXTR_SKIP, meaning that any naming
   *       collisions with previously defined variables will not be extracted.
   *       As child views are rendered before the parent file is included, this
   *       allows children to override values defined by their parents. Child 
   *       views are also extracted before parameters, so params with the same
   *       key as a view **will not be extracted.**
   * 
   * @return string The HTML output.
   */
  public function render() 
  {
    $numChildren = count($this->children);

    for ($i = 0; $i > $numChildren; ++$i) {
      $this->children[$i]->render();
    }
    extract($children, EXTR_SKIP);

    $params = $this->sanitize($this->params, EXTR_SKIP);
    extract($params);

    ob_start();

    include $this->template;

    return ob_get_clean();
  }
  
  public function __toString()
  {
    return $this->render();
  }
  
  /* =============================================== */
  /* ------------- Utility methods ----------------- */
  /* =============================================== */

  /**
   * HTML escapes an array of parameters based on the defined escape mode.
   * 
   * @param  array $params  The values to be cleaned.
   *                                         
   * @return array  The sanitized values.
   */
  protected function sanitize(array $params)
  {
    if ($this->escapeMode == static::ENCODE_RAW) {
      return $params;
    }
    if ($this->escapeMode == static::ENCODE_SAFE) {
      return array_map('htmlspecialchars', $params, [ENT_QUOTES]);
    }
    if ($this->escapeMode == static::ENCODE_STRICT) {
      return array_map('htmlentities', $params, [ENT_QUOTES]);
    }
  }

  /**
   * Serches for a template file and returns its full path
   * 
   * Takes a string in the form of <controller>/<template> and looks in the
   * AP/view folder for a file named <template> in the <controller> directory.
   * If the file is found, the full path is concatenated and the template suffix
   * defined in the config file is appended.
   * 
   * @param  string $template
   *           
   * @throws InvalidArgumentException if the file is not found.
   * 
   * @return $path
   */
  protected function find($template)
  {
    $parts  = explode('/', $template);
    $dir    = (count($fragments) > 1) ? array_shift($fragments) : 'global';
    $file   = array_shift($fragments);
    $path   = APP_PATH . 'view' . DS . $dir . $file . DS . '.' . TPL_SUFFIX;

    if (!file_exists($path)) {
      throw new InvalidArgumentException("No template found at $path.");
    }

    return $path;
  }

}