<?php

namespace MyCodeLab\Http;

class Request
{
  /**
   * @var string[string] HTTP headers
   */
  protected $headers;

  /**
   * @var string HTTP request method
   */
  protected $method;

  /**
   * @var MyCodeLab\Http\Url
   */
  protected $url;

  /**
   * @var mixed[]|mixed  Query string (GET) parameters
   */
  protected $query = array();

  /**
   * @var mixed[]|mixed  Request body (POST) parameters
   */
  protected $body = array();

  /**
   * @var mixed[]|mixed  SERVER parameters
   */
  protected $server = array();

  /**
   * @var string[]|string  COOKIES parameters
   */
  protected $cookie = array();

  /**
   * @var resource[]|resource  FILES parameters
   */
  protected $files = array();

  public function __construct(array $params = array()) 
  {
    $this->headers      = $params['headers']     ?? null;
    $this->method       = $params['method']      ?? null;
    $this->contentType  = $params['contentType'] ?? null;
    $this->url          = $params['url']         ?? null;
    $this->query        = $params['get']         ?? null;
    $this->body         = $params['post']        ?? null;
    $this->server       = $params['server']      ?? null;
    $this->cookie       = $params['cookie']      ?? null;
    $this->files        = $params['files']       ?? null;
  }

  /**
   * Creates a new instance using data from superglobals
   * 
   * @return static
   */
  public static function capture() 
  {    
    $params['url']          = Url::capture();
    $params['headers']      = apache_request_headers();
    $params['server']       = $_SERVER; 
    $params['method']       = $_SERVER['REQUEST_METHOD'];
    $params['contentType']  = $_SERVER['CONTENT_TYPE'] ?? null;
    $params['get']          = $_GET;
    $params['post']         = $_POST;
    $params['files']        = $_FILES;
    $params['cookie']       = $_COOKIE;

    return new static($params);
  }

  /**
   * Getter method for $method
   * 
   * @return string  The HTTP request method
   */
  public function method() 
  {
    return $this->method;   
  }

  /**
   * Getter method for $url
   * 
   * @return string|boolean
   */
  public function url() 
  {
    if(isset($this->url)) {
      return $this->url;
    } else {
      return false;
    }
  }

  /**
   * Fetch a value from $query
   * 
   * @param  string $key  Optional key for specific var.
   * @return mixed|array  Returns the value stored at $key, or the whole array
   *                      if none is defined.
   */
  public function query($key = null) 
  {
    if($key != null) {
      return $this->query[$key];
    } else {
      return $this->query;
    }
  }

  /**
   * Fetch a value from $post
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function body($key = null)
  {
    if($key != null) {
      return $this->body[$key];
    } else {
      return $this->body;
    }
  }

  /**
   * Fetch a value from $server
   * 
   * @param  string $key    Optional key for specific var.
   * @return mixed[]|mixed  Returns the value stored at $key, or the whole 
   *                         array if none is defined.
   */
  public function server($key = null)
  {
    if($key != null) {
      return $this->server[$key];
    } else {
      return $this->server;
    }
  }

  /**
   * Fetch a value from $cookie
   * 
   * @param  string $key      Optional key for specific var.
   * @return string[]|string  Returns the value stored at $key, or the whole 
   *                           array if none is defined.
   */
  public function cookie($key = null)
  {
    if($key != null) {
      return $this->cookie[$key];
    } else {
      return $this->cookie;
    }
  }

  /**
   * Fetch a value from $files
   * 
   * @param  string $key          Optional key for specific var.
   * @return resource[]|resource  Returns the value stored at $key, or the 
   *                               whole array if none is defined.
   */
  public function files($key = null)
  {
    if($key != null) {
      return $this->files[$key];
    } else {
      return $this->files;
    }
  }


}