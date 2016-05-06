<?php

namespace MyCodeLab\Http;

class Session
{
  /**
   * @var bool
   */
  protected $active;

  public function start() 
  {
    session_start();
    
    $this->active = true;
  }

  public function destroy() 
  {
    if(!$this->active) 
    {
      session_start();
    }
    
    session_destroy();
    session_unset();
    setcookie(session_name(), null, 0, "/");
  }

  public function hasKey($key)
  {
    if (isset($_SESSION[$key])){
      return true;
    } else {
      return false;
    }
  }

  public function fetch($key)
  {
    if(isset($_SESSION[$key])) {
      return $_SESSION[$key];
    } else {
      return false;
    }
  }

  public function store($key, $value)
  {
    $_SESSION[$key] = $value;

    return $this;
  }
  
  public function delete($key)
  {
    unset $_SESSION[$key];
    
    return $this;
  }

}
