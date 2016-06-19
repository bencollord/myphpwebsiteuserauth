<?php

namespace MyCodeLab\View;

use InvalidArgumentException;
use MyCodeLab\System\Collection;

class View extends Collection implements Renderable
{
  /**
   * @var string Path to template file.
   */
  protected $template;
  
  /**
   * @var View[]
   */
  protected $children = array();

  /**
   * @var Closure[]
   */
  protected $renderingCallbacks = array();

  public function __construct($path)
  {
    $this->template = $this->find($path);
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
   * Renders the view into an HTML string.
   * 
   * @param string $path 
   *       Optional alternate template to use instead of the one defined in the constructor.
   *
   * @return string The rendered HTML output.
   */
  public function render($path = null)
  {
    $template = (empty($path)) ? $this->template : $this->find($path);
    $children = array();
    
    $this->onRender();
    
    foreach ($this->children as $name => $child) {
      $children[$name] = $child->render();
    }

    extract($this->storage);
    extract($children);

    ob_start();

    include $template;

    return ob_get_clean();
  }


  // Internal Methods
  // ==========================================================================

  protected function onRender()
  {
    foreach ($this->renderingCallbacks as $callback) {
      $callback();
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
    $fragments = explode('/', $template);
    $dir       = (count($fragments) > 1) ? array_shift($fragments) : 'global';
    $file      = array_shift($fragments);
    $suffix    = (defined('TPL_SUFFIX')) ? TPL_SUFFIX : '.php';
    $path      = VIEW_PATH . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $file . $suffix;

    if (!file_exists($path)) {
      throw new InvalidArgumentException("No template found at $path.");
    }

    return $path;
  }

}