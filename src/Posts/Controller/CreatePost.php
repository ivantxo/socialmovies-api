<?php


namespace App\Posts\Controller;


use Psr\Http\Message\ServerRequestInterface;
use Exception;


use App\Posts\Post;
use App\Core\JsonResponse;
use App\Posts\Storage;
use App\Posts\Controller\Output\Post as Output;
use App\Posts\Controller\Output\Request;


final class CreatePost
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $userId = $request->getParsedBody()['user_id'];
        $body = $request->getParsedBody()['body'];
        $likeCount = $request->getParsedBody()['like_count'];
        return $this->storage->create($userId, $body, $likeCount)
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
