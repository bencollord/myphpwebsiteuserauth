<?php

namespace MyPhpWebsiteUserAuth;

use MyCodeLab\Database\Result as DbResult;

class PostRepository
{
  /**
   * @var PostDataGateway
   */
  private $gateway;
  
  public function __construct(PostDataGateway $gateway)
  {
    $this->gateway = $gateway;
  }
  
  public function find($id)
  {
    return new Post($this->gateway, $id);
  }

  public function findAll()
  {
    $result = $this->gateway->select();
    
    return $this->fetchFromResult($result);
  }

  public function findPublic()
  {
    $result = $this->gateway->select('public', true);

    return $this->fetchFromResult($result);
  }

  /**
   * @param  DbResult $result 
   * 
   * @return Post[] $posts
   */
  private function fetchFromResult(DbResult $result)
  {
    $posts  = array();

    foreach ($result as $row) {
      $posts[] = new Post($this->gateway, $row['id']);
    }

    return $posts;
  }

}

