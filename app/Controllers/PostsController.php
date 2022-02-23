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
    private array $postsFromDb;
    private $post;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function showPosts(Request $request, Response $response)
    {
        $this->getPosts();
        return Twig::fromRequest($request)->render(
            $response,
            'posts.twig',
            [
                'posts' => $this->postsFromDb
            ]);
    }

    public function showPost(Request $request, Response $response)
    {
        $id = intval(trim($request->getUri()->getPath(), "/post/"));
        if (!$this->getPostFromDb($id)){
            return Twig::fromRequest($request)->render(
                $response,
                'error.twig');
        }
        return Twig::fromRequest($request)->render(
            $response,
            'post.twig',
            [
                'post' => $this->post
            ]
        );

    }

    private function getPostFromDb(int $id):bool
    {
        $this->post = PostsDb::query()->where('id', '=', $id)->get()->toArray();
        if ($id === 0 || empty($this->post)) {
            return false;
        }
        return true;
    }

    private function getPosts()
    {
        $this->postsFromDb = PostsDb::all()->toArray();
        foreach ($this->postsFromDb as $key => $value) {
            $this->postsFromDb[$key]['content'] = mb_strimwidth($value['content'], 0, 100) . '...';
        }
    }
}
