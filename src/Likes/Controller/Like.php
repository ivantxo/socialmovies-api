<?php

namespace App\Likes\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use Exception;


use App\Likes\Storage;
use App\Posts\Post;
use App\Posts\Controller\Output\Post as Output;
use App\Posts\Controller\Output\Request;


final class Like
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, int $post_id)
    {
        $user_id = $request->getParsedBody()['user_id'];
        return $this->storage->create($post_id, $user_id)
            ->then(
                function (Post $post) {
                    $response = [
                        'post' => Output::fromEntity(
                            $post,
                            Request::detailedPost($post->id)
                        ),
                    ];
                    return JsonResponse::ok($response);
                },
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                }
            );
    }
}
