<?php


namespace App\Posts\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Posts\Post;
use App\Posts\Storage;
use App\Posts\PostNotFound;
use App\Posts\Controller\Output\Post as Output;
use App\Posts\Controller\Output\Request;


final class GetPostById
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
        return $this->storage
            ->getById((int)$postId)
            ->then(
                function (Post $post) {
                    $response = [
                        'post' => Output::fromEntity(
                            $post,
                            Request::detailedProduct($post->id)
                        ),
                    ];
                    return JsonResponse::ok($response);
                }
            )
            ->otherwise(
                function (PostNotFound $error) {
                    return JsonResponse::notFound();
                }
            );
    }
}
