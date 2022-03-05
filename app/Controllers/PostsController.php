<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Post;
use App\Models\Post as PostsDb;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

class PostsController extends Controller
{
    protected ContainerInterface $container;
    private array $postsFromDb;
    private $post;
    protected $Auth;

    public function validatePostsData(Request $request, Response $response): Response|\Slim\Psr7\Message|\Psr\Http\Message\ResponseInterface
    {
        $requestData = $request->getParsedBody();
        if (!empty($requestData)) {
            $this->validator->validate($requestData, [
                'name' => v::notEmpty()->length(10, 100)->setTemplate('Needs more 10 characters'),
                'content' => v::notEmpty()->length(100, 5000)->setTemplate('Need more 100 characters')
            ]);
            $errors = $this->validator->getErrors();
            if (empty($errors)) {
                $this->createPostInDb($requestData);
                return $response->withHeader('Location', '/posts');
            }
            return Twig::fromRequest($request)->render($response, 'postCreate.twig', ['errors' => $errors]);
        }
        return $response->withHeader('Location', '/error')->withStatus(401);
    }

    private function createPostInDb($data)
    {

        $statsPost = empty($data['draft']) ? PostsDb::STATUS_PUBLISHED : PostsDb::STATUS_DRAFT;
        $userId = $this->container->get("auth_user")->toArray()['id'];
        PostsDb::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'content' => $data['content'],
            'status' => $statsPost
        ])->save();
    }

    public function showCreateForm(Request $request, Response $response)
    {
        return Twig::fromRequest($request)->render($response, 'postCreate.twig', []);
    }


    public function showPosts(Request $request, Response $response)
    {
        $this->getPublicPosts();

        return Twig::fromRequest($request)->render(
            $response,
            'posts.twig',
            [
                'posts' => $this->postsFromDb,
                'isValidate' => $this->auth->checkToken($request, $response)
            ]
        );
    }

    public function showEditPost(Request $request, Response $response, array $args)
    {
        $postId = $args['id'];
        $user = $this->container->get('auth_user');
        if (!$user->posts()->where('id', '=', $postId )->exists() || !$this->getPostFromDb($postId)) {
            return $response->withHeader('Location', '/error');
        }
        return Twig::fromRequest($request)->render($response,'postCreate.twig',['postData' => $this->post]);
    }

    public function showPost(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        if ($this->validatePostId($id, $request)) {
            return Twig::fromRequest($request)->render(
                $response,
                'post.twig',
                [
                    'post' => $this->post[0]
                ]);
        }

        return Twig::fromRequest($request)->render(
            $response,
            'error.twig'
        );
    }

    private function validatePostId(int $id, Request $request): bool
    {
        if (!$this->getPostFromDb($id)) {
            return false;
        }
        if ($this->post[0]['status'] !== Post::STATUS_DRAFT) {
            return true;
        }
        $this->Auth = $this->container->get(Auth::class);
        if (!$this->Auth->checkToken($request)) {
            return false;
        }

        $user = $this->container->get('auth_user');

        if ($user->posts()->where('id', '=', $id)->exists()) {
            return true;
        }

        return false;
    }

    private function getPostFromDb(int $id): bool
    {
        $this->post = PostsDb::query()->where('id', '=', $id)->get()->toArray();
        return !($id === 0 || empty($this->post));
    }

    private function getPublicPosts()
    {
        $posts = array_filter(PostsDb::all()->toArray(), fn($i) => $i['status'] !== PostsDb::STATUS_DRAFT);
        foreach ($posts as $key => $value) {
            $posts[$key]['content'] = mb_strimwidth($value['content'], 0, 100) . '...';
        }
        $this->postsFromDb = $posts;
    }
    /**
     * @param Auth|mixed $auth
     * @return PostsController
     */
}
