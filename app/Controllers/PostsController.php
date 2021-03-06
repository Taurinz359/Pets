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

    public function createPost(Request $request, Response $response): Response|\Slim\Psr7\Message|\Psr\Http\Message\ResponseInterface
    {
        $requestData = $request->getParsedBody();
        if (!empty($requestData)) {
            $this->validatePostData($requestData);
            $this->validator->getErrors();
            if (empty($_SESSION['validateErrors'])) {
                $this->createPostInDb($requestData);
                return $response->withHeader('Location', '/posts');
            }
            return $response->withHeader('Location', '/posts/create');
        }
        return $response->withHeader('Location', '/error')->withStatus(401);
    }

    public function validatePostData($requestData)
    {
        $this->validator->validate($requestData, [
            'name' => v::notEmpty()->length(10, 100)->setTemplate('Needs more 10 characters'),
            'content' => v::notEmpty()->length(100, 5000)->setTemplate('Need more 100 characters')
        ]);
    }

    public function deletePost(Request $request, Response $response, array $args)
    {
        $postId = $args['id'];
        $authUser = $this->container->get('auth_user');
        $postFromDb = $authUser->Posts()->where('id', '=', $postId)->get()->toArray();
        if (empty($postFromDb)) {
            $response->withAddedHeader('Location', '/error');
        }
        $delete = $authUser->Posts()->where('id', '=', $postId)->delete();
        if ($delete !== 1) {
            $response->withAddedHeader('Location', '/error');
        }
        return $response->withAddedHeader('Location', '/home');
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
        session_start();
        $validateErrors = $_SESSION['validateErrors'];
        session_destroy();
        return Twig::fromRequest($request)->render($response, 'postCreate.twig', [
            'isValidate' => !empty($this->auth),
            'createPostsErrors' => $validateErrors
        ]);
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
        $postFromDb = $user->posts()->where('id', '=', $postId)->get()->toArray();
        if (empty($postFromDb) || $postFromDb[0]['status'] !== 1) {
            return $response->withHeader('Location', '/error');
        }
        session_start();
        $validatorErrors = $_SESSION['validateErrors'];
        $requestData = $_SESSION['requestData'];
        return Twig::fromRequest($request)->render($response, 'postCreate.twig', [
            'post' => empty($requestData)? $postFromDb[0] : $requestData,
            'isValidate' => !empty($this->auth),
            'editPostErrors' => $validatorErrors,
        ]);
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
                ]
            );
        }

        return Twig::fromRequest($request)->render(
            $response,
            'error.twig'
        );
    }

    public function editPost(Request $request, Response $response, array $args)
    {
        $requestData = $request->getParsedBody();
        $postId = $args['id'];
        $authUser = $this->container->get('auth_user');
        $postFromDb = $authUser->posts()->where('id', '=', $postId)->get()->toArray();
        if (empty($postFromDb) || empty($requestData) || $postFromDb[0]['status'] !== 1) {
            return $response->withHeader('Location', '/error');
        }
        $this->validatePostData($request->getParsedBody());
        $this->validator->getErrors();
        if (!empty($_SESSION['validateErrors'])) {
            //???????????????? ???????????? ?????? ???????????????? ????????????
            session_start();
            $_SESSION['requestData'] = $requestData += ['id' => $postId];
            return $response->withHeader('Location', "/post/$postId/edit");
        }
        Post::find($postId)->update([
            'name' => $requestData['name'],
            'content' => $requestData['content'],
            'status' => empty($requestData['draft']) ? PostsDb::STATUS_PUBLISHED : PostsDb::STATUS_DRAFT
        ]);
        return $response->withAddedHeader('Location', '/home');
    }

    private function validatePostId(int $id, Request $request): bool
    {
        if (!$this->getPostFromDb($id)) {
            return false;
        }
        if ($this->post[0]['status'] !== Post::STATUS_DRAFT) {
            return true;
        }
        if (!$this->auth->checkToken($request)) {
            return false;
        }

        if ($this->container->get('auth_user')->posts()->where('id', '=', $id)->exists()) {
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
