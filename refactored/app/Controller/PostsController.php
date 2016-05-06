<?php

namespace MyPhpWebsiteUserAuth\Controller;

use MyCodeLab\View\{View, Page};

class PostsController
{
  public function init(Authentication $auth)
  {
    $this->session->start();
  }

  public function home() 
  {
    $posts = Post::findAll('public');
    $view  = new View('posts/home');

    $view->set('posts', $posts)
         ->set('page',  $this->page);
 
  }

  public function add() 
  {
    $post     = new Post();
    $content  = $this->request->post('details');
    $isPublic = $this->request->post('public');
    
    $post->setDetails($content)
         ->setPublic($isPublic)
         ->save();
    
    $this->response->redirect('posts/home')
  }

  public function edit($id)
  {
    $post = Post::find($id);
    
    if ($this->request->isPost()) {
      $content  = $this->request->post('details');
      $isPublic = $this->request->post('public');
    
      $post->setDetails($content)
           ->setPublic($isPublic)
           ->save();
    }
  }

  public function delete($id) 
  {
    $post = Post::find($id); 
    
    $post->delete();
    $this->response->redirect('posts/home');
  }

}
