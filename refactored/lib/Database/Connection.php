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
  
  public function sqlCommand($sql = null)
  {
    $command = new SqlCommand($this);
    
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
  
  /* ===================================================== */
  /* -----------------    Deprecated    ------------------ */
  /* ===================================================== */
  
  /**
   * Get database connection based on config constants
   * 
   * @deprecated Will be replaced with dependency injection.
   * 
   * @return self
   */
  public static function forge($fetchMode = PDO::FETCH_ASSOC) 
  {
    $driver   = DB_DRIVER;
    $host     = DB_HOST;
    $dbName   = DB_NAME;
    $username = DB_USER;
    $password = DB_PASS;
    
    try {
      $instance = new static("$driver:host=$host;dbname=$dbName", $username, $password);
      
      $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $fetchMode);
    } catch (PDOException $e) {
      throw new Exception('Error connecting to database ' . $e->getMessage());
    }
    
    return $instance;
  }
  
}