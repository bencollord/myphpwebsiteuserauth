<?php

namespace MyCodeLab\Http;

class Url
{
  /**
   * @var string
   */
  protected $domain;

  /**
   * @var string
   */
  protected $path;

  public function __construct($domain, $path)
  {
    $this->domain = $domain;
    $this->path   = $path;
  }

  public static function capture()
  {
    $domain = defined(DOMAIN_NAME) ? DOMAIN_NAME : $_SERVER['HTTP_HOST'];
    $path   = $_GET['path'] ?? null;

    return new static($domain, '/'. $path);
  }

  public function __toString()
  {
    return $this->domain . $this->path;
  }

  /**
   * @return string
   */
  public function domain()
  {
    return $this->domain;
  }

  /**
   * Gets full path string.
   * 
   * @return string
   */
  public function path()
  {
    return '/' . $this->path;
  }

  /**
   * @return string[]
   */
  public function parse()
  {
    return parse_url($this->__toString());
  }

}