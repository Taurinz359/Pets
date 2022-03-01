<?php

namespace App\Controllers;

use App\Auth;
use App\Validation\Validator;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;
use App\Models\Posts as PostsDb;
use Respect\Validation\Validator as v;

class PostsController extends Controller
{
    protected ContainerInterface $container;
    private array $postsFromDb;
    private $post;

    //todo добавить отображение кнопки логаут

    public function createPost(Request $request, Response $response)
    {
        $requestData = $request->getParsedBody();
        $this->validator->validate($requestData,[
            'name' => v::notEmpty()->length(10,100)->setTemplate('Needs more 10 characters'),
            'content' => v::notEmpty()->length(100,5000)->setTemplate('Need more 100 characters')
        ]);
        $error = $this->validator->getErrors();
        var_dump($error); die;
        return $response->withHeader('Location','/posts');
    }

    public function showCreateForm(Request $request, Response $response)
    {
        return Twig::fromRequest($request)->render($response, 'postsCreate.twig', []);
    }


    public function showPosts(Request $request, Response $response)
    {
        $this->getPosts();
        return Twig::fromRequest($request)->render(
            $response,
            'posts.twig',
            [
                'posts' => $this->postsFromDb,
                'isValidate' => $this->auth->checkToken($request, $response)
            ]
        );
    }

    public function showPost(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        if ($this->getPostFromDb($id)) {
            return Twig::fromRequest($request)->render(
                $response,
                'error.twig'
            );
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
