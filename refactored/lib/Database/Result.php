<?php

namespace MyCodeLab\Database;

use PDO;
use PDOStatement;
use PDOException;
use ArrayAccess;
use SeekableIterator;
use OutOfBoundsException;

/**
 * Represents the result of an SQL query.
 * 
 * Experimental class that wraps data from \PDOStatement in a static interface 
 * so that it can be mocked for tests or later used to define a more general
 * interface for result sets in the framework.
 */
class Result implements ArrayAccess, SeekableIterator
{
  /**
   * @var int Points to the current row in the set.
   */ 
  protected $cursor = 0; 
  
  /**
   * @var array[string] The records returned from the database.
   */ 
  protected $rows;
  
  /**
   * @var string[] The names of the returned columns
   */
  protected $columns;
  
  /**
   * @var string SQLSTATE error code.
   */ 
  protected $sqlStateCode;
  
  /**
   * @var string Driver error code.
   */ 
  protected $errorCode;
  
  /**
   * @var string Driver error message.
   */ 
  protected $errorMessage;
  
  /** 
   * @var int
   */ 
  protected $columnCount;
  
  /** 
   * @var int
   */ 
  protected $affectedRows;

  /**
   * @todo: Clean this up. May indicate need to break up into smaller classes
   */
  public function __construct(PDOStatement $statement)
  {
    // @todo: Find cleaner way to deal with this. 
    try {
      $this->rows    = $statement->fetchAll(PDO::FETCH_ASSOC);
      $this->columns = array_keys($this->rows[0]);
    } catch (PDOException $e) {
      $this->rows    = null;
      $this->columns = null;
    }

    $this->columnCount  = $statement->columnCount();
    $this->affectedRows = $statement->rowCount();
    
    $errors = $statement->errorInfo();
    
    $this->sqlState     = $errors[0];
    $this->errorCode    = $errors[1];
    $this->errorMessage = $errors[2];
  }

  public function rowCount() 
  {
    if ($this->hasRows()) {
      return count($this->rows);
    } else {
      return $this->affectedRows;
    }
  }

  public function isEmpty()
  {
    return (empty($this->rows)) ? true : false;
  }
  
  public function hasRows()
  {
    return (empty($this->rows)) ? false : true;
  }

  public function getRows() 
  {
    return $this->rows; 
  }

  public function getAffectedRows() 
  {
    return $this->affectedRows; 
  }
  
  public function getSqlStateCode()
  {
    return $this->sqlStateCode;
  }

  public function getErrorCode() 
  {
    return $this->errorCode; 
  }

  public function getErrorMessage() 
  {
    return $this->errorMessage; 
  }

  public function getColumnCount() 
  {
    return $this->columnCount; 
  }

  // ArrayAccess implementation
  // =======================================

  public function offsetExists($offset)
  {
    return isset($this->rows[$this->cursor][$offset]);
  }

  public function offsetSet($offset, $value)
  {
    $this->rows[$this->cursor][$offset] = $value;
  }

  public function offsetGet($offset)
  {
    return $this->rows[$this->cursor][$offset];
  }

  public function offsetUnset($offset)
  {
    unset($this->rows[$this->cursor][$offset]);
  }

  // Iteration Methods
  // =======================================
  
  public function seek($position)
  {
    if (!isset($this->rows[$position])) {
      throw new OutOfBoundsException("No row found at position $position");
    }
    
    $this->cursor = $position;
      
    return $this;
  }

  public function current()
  {
    return $this->rows[$this->cursor];
  }
    
  public function key()
  {
    return $this->cursor;
  }
    
  public function next()
  {
    ++$this->cursor;
    
    return $this;
  }
    
  public function rewind()
  {
    $this->cursor = 0;
    
    return $this;
  }
    
  public function valid()
  {
    return isset($this->rows[$this->cursor]);
  }
    

}
