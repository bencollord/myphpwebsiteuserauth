<?php

namespace MyPhpWebsiteUserAuth\Model;

use MyCodeLab\Auth\Exceptions\UserNotFoundException;

class UserRepository
{
  protected $database;
  
  public function __construct(DbConnection $db)
  {
    $this->database = $db;
  }
  
  public function find($username)
  {
    $sql      = "SELECT id, username, password FROM " . static::TABLE . " WHERE username=:username";
    $params   = ['username' => $username];
    $command  = $this->database->sqlCommand();
    
    $result = $command->write($sql, $params)->execute();

    if(!$result->hasRows()) {
      return false;
    }

    $user = new User($result['username'], $result['password'], $result['id']);
    $user->isRegistered = true;
  }
  
}