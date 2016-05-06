<?php

namespace MyCodeLab\View;

/**
 * Objects that can be rendered into an output string
 */
interface Renderable
{
  /**
   * Compiles the view into a string for output
   * 
   * @return string
   */
  public function render();
  
}