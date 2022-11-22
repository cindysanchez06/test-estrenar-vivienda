<?php

namespace Drupal\posts\Controller;

use Drupal\Core\Controller\ControllerBase;

class PostsController extends ControllerBase
{
    protected  $postsServices;

    public function __construct()
    {
        $this->postsServices = \Drupal::service('posts.posts_services');
    }

    public function index()
    {
        $posts = $this->postsServices->getPosts();
        return [
          '#theme' => 'posts_lists',
          '#items' => $posts,
          '#title' => $this->t('Lists Posts')
        ];
    }
}