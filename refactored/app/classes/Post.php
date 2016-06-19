<?php

namespace MyPhpWebsiteUserAuth;

use DateTime;
use DomainException;

class Post
{
  /**
   * @var int Post's unique identification key. If empty, indicates a new Post.
   */
  protected $id;

  /**
   * @var string The body of the post.
   */
  protected $details;

  /**
   * @var \DateTime Timestamp of post creation.
   */
  protected $postTime;

  /**
   * @var \DateTime Timestamp of last edit.
   */
  protected $editTime;

  /**
   * @var bool
   */
  protected $isPublic;

  /**                                     
   * @return Post[]|false
   */
  public static function loadAll($filter = null) 
  {
    $gateway = new PostDataGateway();

    // @todo: find a cleaner way of doing this
    switch ($filter) {
      case 'public': 
        $result = $gateway->select('public', true);
        break;
      default: 
        $result = $gateway->select();
    }

    if (empty($result)) { 
      return false; 
    }

    foreach ($result as $row) {
      $post = new Post();

      $post->id       = $result['id'];
      $post->details  = $result['details'];
      $post->postTime = new DateTime($result['date_posted'] . ' ' . $result['time_posted']);
      $post->editTime = new DateTime($result['date_edited'] . ' ' . $result['time_edited']);
      $post->isPublic = $result['public'];

      $posts[] = $post;
    }

    return $posts;
  }

  public function __construct(PostDataGateway $gateway, $id = null)
  {
    $this->gateway = $gateway;
    $this->id      = $id;

    if (!empty($id)) {
      $this->load($id);
    }
  }

  // Accessor methods
  // ===========================================


  /**
   * @return int
   */
  public function id()        
  { 
    return $this->id;      
  }

  /**
   * @return string
   */
  public function details()   
  {
    return $this->details;  
  }

  /**
   * @return DateTime
   */
  public function postTime()  
  {
    return $this->postTime; 
  }

  /**
   * @return DateTime
   */
  public function editTime()  
  {
    return $this->editTime; 
  }

  /**
   * @return bool
   */
  public function isPublic()  
  {
    return $this->isPublic; 
  }

  /**
   * Sets content and access level with a timestamp.
   *  
   * @param string $details  Post content
   * @param bool   $public
   *                              
   * @return $this
   */
  public function compose($details, $public = true) 
  { 
    $timestamp = new DateTime();

    $this->details  = $details;
    $this->isPublic = (bool) $public;
    $this->editTime = $timestamp;
    $this->postTime = $this->postTime ?: $timestamp;

    return $this;
  }

  public function save()
  {    
    if (empty($this->details)) {
      throw new DomainException('Post cannot be blank');
    }

    $data = [
      'id'       => $this->id,
      'details'  => $this->details,
      'postTime' => $this->postTime->format('Y-m-d'),
      'postDate' => $this->postTime->format('H:i:s'),
      'editTime' => $this->editTime->format('Y-m-d'),
      'editDate' => $this->editTime->format('H:i:s'),
      'isPublic' => $this->isPublic
    ];

    // Check if new or existing post
    if (isset($this->id)) {
      $this->gateway->update($data);
    } else {
      $this->gateway->insert($data);
    }
  }

  public function delete() 
  {
    $this->gateway->delete($this->id);
  }

  private function load($id)
  {
    $result = $this->gateway->select('id', $id);

    if (empty($result)) {
      throw new NotFoundException("No post exists with the id $id");
    }

    $this->details  = $result['details'];
    $this->postTime = new DateTime($result['date_posted'] . ' ' . $result['time_posted']);
    $this->editTime = new DateTime($result['date_edited'] . ' ' . $result['time_edited']);
    $this->isPublic = $result['public'];
  }

}
