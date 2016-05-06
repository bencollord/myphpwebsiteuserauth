<?php

namespace MyPhpWebsiteUserAuth\Model;

use MyCodeLab\Database\Connection as Database;
use MyCodeLab\Auth\Identity;
use MyCodeLab\Auth\Exceptions\FailedRegistrationException;

class User implements Identity
{  
  const TABLE = AUTH_USER_TABLE;
  
  /**
   * @var MyCodeLab\Database\Connection
   */
  protected $connection;
  
  /**
   * @var int
   */
  protected $id;
  
  /**
   * @var string
   */
  protected $username;

  /**
   * @var string
   */
  protected $password;

  public function __construct($username = null, $password = null, $id = null)
  {
    $this->username = $username;
    $this->password = $password;
    $this->id       = $id;
  }
  
  public function isRegistered()
  {
    if (isset($this->id)) {
      return true;
    } else {
      return false;
    }
  }

  public function getUsername() 
  {
    return $this->username;
  }

  public function validatePassword($password)
  {
    if ($this->password === $password) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @todo Hashing algorithm and security
   */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }
  
  public function save() 
  {
    $sql      = "INSERT INTO " . static::TABLE . " (username, password) VALUES (:username, :password)";
    $params   = ['username' => $this->username, 'password' => $this->password];
    $command  = $this->connection->sqlCommand();
    
    if ($this->isRegistered) {
      throw new RegistrationException("There is already a user $username registered");
    }

    $result = $command->write($sql, $params)->execute();
    
    if ($result->rowCount() < 1) {
      throw new FailedRegistrationException("Error saving user to database");
    } 
  }

}
