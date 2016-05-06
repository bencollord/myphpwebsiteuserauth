<?php

namespace MyCodeLab\Auth;

use MyCodeLab\System\Object;
use MyCodeLab\Database\Connection as Database;
use MyCodeLab\Auth\Exceptions\RegistrationException;

interface Identity
{
  /**
   * Locate and fetch an identity from storage.
   * 
   * @param  string $username
   * 
   * @return Identity
   */
  public static function find($username);
  
  /**
   * Gets the unique identifier.
   * 
   * @return string
   */
  public function getUsername();

  /**
   * @return bool
   */
  public function isRegistered();

  /**
   * @param  string
   * 
   * @return bool
   */
  public function validatePassword($password);

  /**
   * @param string
   */
  public function setPassword($password);
  
  /**
   * @return void
   */
  public function save();

}
