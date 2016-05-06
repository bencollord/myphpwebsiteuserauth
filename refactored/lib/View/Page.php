<?php 

namespace MyCodeLab\View;

class Page extends View implements Renderable
{
  protected $title;
  protected $metaTags    = array();
  protected $stylesheets = array();
  protected $scripts     = array();

  /**
   * @return string $this->title
   */
  public function getTitle() 
  {
    return $this->title;
  }

  /**
   * @param string $title
   * @return $this
   */
  public function setTitle($title)
  {
    $this->title = $title;
    
    return $this;
  }
  
  /**
   * Registers a meta tag.
   * 
   * @return $this
   */
  public function addMetaTag($name, $value) 
  { 
    // @todo: method body
    
    return $this; 
  }
  
  /**
   * Registers a CSS file.
   * 
   * @return $this
   */
  public function addStylesheet($path, $handle = null) 
  { 
    // @todo: method body
    
    return $this; 
  }
  
  /**
   * Registers a JavaScript file.
   * 
   * @return $this
   */
  public function addScript($path, $handle = null) 
  { 
    // @todo: method body
    
    return $this; 
  }
  
}