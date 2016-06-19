<?php

namespace MyPhpWebsiteUserAuth;

use MyCodeLab\Database\Connection as DbConnection;

class PostDataGateway
{
  /**
   * Database table constant
   */
  const TABLE = 'listtbl';

  /**
   * @var MyCodeLab\Database\Connection
   */
  protected $connection;

  public function __construct(DbConnection $connection) 
  {
    $this->connection = $connection;
  }

  /**
   * Get data from all posts in the table.
   * 
   * @return MyCodeLab\Database\Result
   */
  public function select($column = null, $value = null) 
  {
    $sql      = "SELECT id, details, date_posted, time_posted, date_edited, time_edited, public " . 
                "FROM " . self::TABLE;
    $command  = $this->connection->command();
    
    $command->write($sql);
    
    if ($column && $value) {
      $command->write(" WHERE $column=:$column", [$column => $value]);
    }
    
    $result = $command->execute();

    return $result;
  }

  public function insert($postData)
  {
    $command = $this->connection->command();
    
    $sql     = "INSERT INTO " . self::TABLE . "(details, date_posted, time_posted, date_edited, time_edited, public)" . "VALUES (:details, :date_posted, :time_posted, :public)";
    
    $params  = [
      'details'     => $postData['details'],
      'time_posted' => $postData['postTime'],
      'date_posted' => $postData['postDate'],
      'public'      => $postData['isPublic']
    ];

    $result = $command->write($sql, $params)->execute();
    
    if ($result->affectedRows() == 0) {
      throw new RuntimeException("Post could not be saved to database");
    }
  }

  public function update($postData) 
  {
    $command = $this->connection->command();
    
    $sql     = "UPDATE" . self::TABLE . " " .
               "SET details=:details, date_edited=:date, time_edited=:time, public=:public " .
               "WHERE id=:id";
    
    $params   = [
      'id'      => $postData['id'],
      'details' => $postData['details'],
      'date'    => $postData['editDate'],
      'time'    => $postData['editTime'],
      'public'  => $postData['isPublic']
    ];

    $result = $command->write($sql, $params)->execute();
    
    if ($result->affectedRows() == 0) {
      throw new RuntimeException("Post could not be saved to database");
    }
  }

  public function delete($id) 
  {
    $sql     = "DELETE FROM " . self::TABLE  . " WHERE id=:id";
    $command = $this->connection->command($sql);
    $result  = $command->bind(['id' => $id])->execute();
    
    if ($result->affectedRows() == 0) {
      throw new RuntimeException("Post could not be deleted from database");
    }
  }

}

