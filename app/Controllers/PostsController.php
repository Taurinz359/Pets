<?php

namespace App\Controllers;

use App\Auth;
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
    private Auth $auth;

    //todo добавить отображение кнопки логаут
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->auth = $this->container->get(Auth::class);
    }

    public function writePost(Request $request, Response $response)
    {
        return Twig::fromRequest($request)->render($response,'writePost.twig',[]);
    }



    public function showPosts(Request $request, Response $response)
    {
        $this->getPosts();
        return Twig::fromRequest($request)->render(
            $response,
            'posts.twig',
            [
                'posts' => $this->postsFromDb,
                'isValidate' => $this->auth->checkToken($request,$response)
            ]);
    }

    public function showPost(Request $request, Response $response,array $args)
    {
        $id = $args['id'];
        if ($this->getPostFromDb($id)) {
            return Twig::fromRequest($request)->render(
                $response,
                'error.twig');
        }
        return Twig::fromRequest($request)->render(
            $response,
            'post.twig',
            [
                'post' => $this->post[0]
            ]
        );

    }

    private function getPostFromDb(int $id): bool
    {
        $this->post = PostsDb::query()->where('id', '=', $id)->get()->toArray();
        return ($id === 0 || empty($this->post));
    }

    private function getPosts()
    {
        $this->postsFromDb = PostsDb::all()->toArray();
        foreach ($this->postsFromDb as $key => $value) {
            $this->postsFromDb[$key]['content'] = mb_strimwidth($value['content'], 0, 100) . '...';
        }
    }

    /**
     * @param Auth|mixed $auth
     * @return PostsController
     */

}
