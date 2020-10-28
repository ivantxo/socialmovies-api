<?php

namespace App\Likes\Controller;


use Psr\Http\Message\ServerRequestInterface;
use Exception;

use App\Core\JsonResponse;
use App\Likes\Storage;
use App\Posts\Post;
use App\Posts\Controller\Output\Post as Output;
use App\Posts\Controller\Output\Request;


final class UnLike
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, int $postId)
    {
        $userId = $request->getParsedBody()['user_id'];
        return $this->storage->delete($postId, $userId)
            ->then(
                function () use ($postId) {
                    return $this->storage->getPost($postId);
                }
            )
            ->then(
                function (Post $post) {
                    $likeCount = $post->like_count - 1;
                    return $this->storage->updateLikeCount($post->id, $likeCount);
                }
            )
            ->then(
                function () use ($postId) {
                    return $this->storage->getPost($postId);
                }
            )
            ->then(
                function (Post $post) {
                    $response = [
                        'post' => Output::fromEntity(
                            $post,
                            Request::detailedPost($post->id)
                        ),
                    ];
                    return JsonResponse::ok($response);
                }
            )
            ->otherwise(
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                }
            );
    }
}
