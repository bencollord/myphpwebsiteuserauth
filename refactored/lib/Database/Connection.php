<?php

namespace MyCodeLab\Database;

use PDO;
use PDOException;

/**
 * Represents a database connection.
 * 
 * Wraps PDO with a streamlined interface.
 */
class Connection extends PDO
{  
  public function __construct($database, $username, $password, $host = 'localhost', $driver = 'mysql')
  {
    parent::__construct("$driver:host=$host;dbname=$database", $username, $password);
  }
  
  public function command($sql = null)
  {
    $command = new Command($this);
    
    if ($sql) {
      $command->write($sql);
    }
    
    return $command;
  }
  
  public function query($sql, $params = array())
  {
    if (empty($params)) {
      $statement = parent::query($sql);
    } else {
      $statement = $this->prepare($sql);
      
      foreach ($params as $key => $value) {
        $statement->bindValue(":$key", $value);
      }
      
      $statement->execute();
    }
    
    return $statement->fetchAll();
  }
  
}