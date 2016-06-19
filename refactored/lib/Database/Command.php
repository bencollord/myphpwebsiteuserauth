<?php

namespace MyCodeLab\Database;

/**
 * Represents a SQL DML command.
 */
class Command
{  
  /**
   * @var Connection Link to database
   */
  protected $connection;
  
  /**
   * @var string The raw SQL to be executed on the database
   */
  protected $sql;

  /**
   * @var array List of parameters to be bound in a prepared statement. 
   */
  protected $parameters = array();

  public function __construct(Connection $conn = null)
  {
    $this->connection = $conn;
  }

  public function write($cmdText, array $params = array())
  {
    $this->sql .= $cmdText;
    
    $this->bind($params);
    
    return $this;
  }
  
  public function writeOver($cmdText, array $params = array())
  {
    $this->sql = $cmdText;
    
    if (!empty($params)) {
      $this->bind($params, true);
    }
    
    return $this;
  }
  
  /**
   * Adds entries to the $parameters array.
   * 
   * @param mixed[] $params       Key/Value pairs representing query params.
   * @param bool    $eraseCurrent Whether or not to erase any existing params.
   * @return $this
   */
  public function bind(array $params, $overwrite = false)
  {
    $this->parameters = ($overwrite === true) ? $params : array_merge($this->parameters, $params);
    
    return $this;
  }

  public function execute()
  {
    $statement = $this->connection->prepare($this);
    
    foreach ($this->parameters as $key => $value) {
      $statement->bindValue(":$key", $value);
    }
    
    $statement->execute();
    
    return new Result($statement);
  }
  
  public function __toString()
  {
    return $this->sql;
  }
    
  public function readCompiled()
  {
    $cmdText = $this->sql;
    
    if (!empty($this-parameters)) {
      foreach ($this->parameters as $key => $value) {
        $cmdText = str_replace(":$key", (string)$value, $cmdText);
      }
    }
    
    return $cmdText;
  }
  
  /**
   * @deprecated: will be removed.
   */
  public function executeQuery()
  {
    $statement = $this->connection->prepare($this);
    
    foreach ($this->parameters as $key => $value) {
      $statement->bindValue(":$key", $value);
    }
    
    $statement->execute();
    
    return $statement->fetchAll();
  }

}