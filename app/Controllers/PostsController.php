<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use App\Models\Posts as PostsDb;

class PostsController
{
    protected ContainerInterface $container;
    private $postsFromDb;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function showPosts(Request $request, Response $response)
    {
        $this->getPosts();
        return Twig::fromRequest($request)->render($response, 'posts.twig',
            [
                'posts' => $this->postsFromDb]);
    }

    public function showPost(Request $request, Response $response)
    {
        var_dump($request->getUri()->getPath());
        return Twig::fromRequest($request)->render($response, 'post.twig',
            []);
    }

    private function getPosts()
    {
        $this->postsFromDb = PostsDb::all()->toArray();
        foreach ($this->postsFromDb as $key => $value) {
            $this->postsFromDb[$key]['content'] = mb_strimwidth($value['content'], 0, 100) . '...';
        }
    }
}