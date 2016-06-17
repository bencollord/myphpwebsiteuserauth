<?php

namespace MyCodeLab\System;

class ClassLibrary
{
  protected $namespace;
  protected $directory;
  
  public function __construct($namespace, $directory)
  {
    $this->namespace = $namespace;
    $this->directory = $directory;
  }
  
  public function register() 
  {
    spl_autoload_register([$this, 'loadFile']);
  }

  public function loadFile($fullyQualifiedName)
  {
    $classPath = ltrim($fullyQualifiedName, $this->namespace);
    $filepath  = ROOT . $this->directory . str_replace('\\', DIRECTORY_SEPARATOR, $classPath) . '.php';
    
    if (file_exists($filepath)) {
      require_once $filepath;
    }
  }

}