<?php

namespace MyPhpWebsiteUserAuth\Controller;

use MyCodeLab\Auth\{Authentication, Result};

class UsersController extends Controller
{
  /**
   * @var MyCodeLab\Auth\Authentication
   */
  private $auth;

  public function __construct(Authentication $auth)
  {
    $this->auth = $auth;
  }

  public function login() 
  {
    $username = $this->request->post('username');
    $password = $this->request->post('password');

    $result = $this->auth->run($username, $password);

    if ($result->isValid()) {
      $this->response->redirect('posts/users');
    } else {
      $this->session->write('flash', $result->message);
      $this->response->redirect('posts/home');
    }
  }

  public function logout() 
  {
    $this->auth->clear();
    $this->response->redirect('posts/home');
  }

  public function register() 
  {
    $username = $this->request->post('username');
    $password = $this->request->post('password');
    $user     = new User($username, $password);
    
    try {
      $user->save();
    } catch (RegistrationException $e) {
      $this->session->write('flash', $e->getMessage());
      $this->response->redirect('posts/home');
    }
  }

}


