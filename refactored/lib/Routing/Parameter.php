<?php

namespace MyCodeLab\Routing;

class Rule
{  
  private static $token = '/\<([A-Za-z0-9]+)(:.*?)?\>/';
  
  const ALL   = '/.+/';
  const ANY   = '/[^/]+/';
  const INT   = '/[0-9]+/';
  const ALPHA = '/[A-Za-z]+/';
  const ALNUM = '/[A-Za-z0-9]+/';
  
  /**
   * @var string
   */
  protected $pattern;
  
  public function __construct($pattern = null)
  {
    $this->pattern = ($pattern) ? $pattern : self::MATCH_ANY;
  }
  
  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }
  
}