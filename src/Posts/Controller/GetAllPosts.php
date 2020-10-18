<?php


namespace App\Posts\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Posts\Post;
use App\Posts\Storage;
use App\Posts\Controller\Output\Post as Output;
use App\Posts\Controller\Output\Request;


final class GetAllPosts
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
        return $this->storage->getAll()
            ->then(
                function (array $posts) {
                    $response = [
                        'posts' => $this->mapPosts(...$posts),
                        'count' => count($posts),
                    ];
                    return JsonResponse::ok($response);
                }
            );
    }

    private function mapPosts(Post ...$posts): array
    {
        return array_map(
            function (Post $post) {
                return Output::fromEntity(
                    $post,
                    Request::detailedPost($post->id)
                );
            },
            $posts
        );
    }
}
