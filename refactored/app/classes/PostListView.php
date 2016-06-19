<?php

namespace MyPhpWebsiteUserAuth;

use StdClass;
use MyCodeLab\View\View;

class PostListView extends View
{
  private $posts = array();

  public function __construct($template, array $posts)
  {
    parent::__construct($template);
    
    $this->posts = $posts;
  }

  protected function onRender($template = null)
  {
    $posts = array();
    
    foreach ($this->posts as $post)
    {
      $postView = new StdClass();
      
      $postView->id       = $post->id();
      $postView->details  = $post->details();
      $postView->postTime = $post->postTime()->format('H:i A');
      $postView->postDate = $post->postTime()->format('F j, Y');
      $postView->editTime = $post->editTime()->format('H:i A');
      $postView->editDate = $post->editTime()->format('F j, Y');
      $postView->isPublic = $post->isPublic();
      
      $posts[] = $postView;
    }
    
    $this->set('posts', $posts);
  }
  
}
