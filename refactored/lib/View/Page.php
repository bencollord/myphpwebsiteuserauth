<?php 

namespace MyCodeLab\View;

class Page extends View
{
  protected $title;
  protected $metaTags    = array();
  protected $stylesheets = array();
  protected $scripts     = array();
  
  public function __construct($template, $title = null)
  {
    $this->title = $title ?? DOMAIN_NAME;
    parent::__construct($template);
  }
  
  /**
   * Registers a meta tag.
   * 
   * @return $this
   */
  public function addMeta($name, $value) 
  { 
    $this->metaTags[$name] = $value;
    
    return $this; 
  }
  
  /**
   * Registers a CSS file.
   * 
   * @return $this
   */
  public function addStylesheet($path, $handle = null) 
  { 
    if ($handle != null) {
      $this->stylesheets[$handle] = $path;
    } else {
      $this->stylesheets[] = $path;
    }
    
    return $this; 
  }
  
  /**
   * Registers a JavaScript file.
   * 
   * @return $this
   */
  public function addScript($path, $handle = null) 
  { 
    if ($handle != null) {
      $this->scripts[$handle] = $path;
    } else {
      $this->scripts[] = $path;
    }
    
    return $this; 
  }
  
}