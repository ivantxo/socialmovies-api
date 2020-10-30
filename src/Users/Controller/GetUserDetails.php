<?php


namespace App\Users\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Posts\Post;
use App\Users\Storage;
use App\Posts\Controller\Output\Post as PostOutput;
use App\Posts\Controller\Output\Request;


final class GetUserDetails
{
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, int $userId)
    {
        return $this->storage->getPosts($userId)
            ->then(
                function (array $posts) {
                    $response = [
                        'posts' => $this->mapPosts(...$posts),
                        'count' => count($posts)
                    ];
                    return JsonResponse::ok($response);
                }
            );
    }

    private function mapPosts(Post ...$posts): array
    {
        return array_map(
            function (Post $post) {
                return PostOutput::fromEntity(
                    $post,
                    Request::detailedPost($post->id)
                );
            },
            $posts
        );
    }
}
