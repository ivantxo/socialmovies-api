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
        $user_id = $request->getParsedBody()['user_id'];
        $like_count = $request->getParsedBody()['like_count'];
        return $this->storage->create($user_id, $like_count)
            ->then(
                function (Post $post) {
                    $response = [
                        'post' => Output::fromEntity(
                            $post,
                            Request::detailedProduct($post->id)
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
