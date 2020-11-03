<?php


namespace App\Authentication;


use App\Posts\PostNotFound;
use Psr\Http\Message\ServerRequestInterface;
use Exception;


use App\Core\JsonResponse;


final class GetAuthenticatedUser
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, int $userId)
    {
        $response = [];
        return $this->storage->getByUserId($userId)
            ->then(
                function (User $user) use ($response) {
                    $response['credentials'] = $user;
                    return $response;
                }
            )
            ->then(
                function (array $response) use ($userId) {
                    return $this->storage->getPosts($userId)
                        ->then(
                            function (array $posts) use ($response) {
                                $response['posts'] = $posts;
                                return $response;
                            }
                        );
                }
            )
            ->then(
                function (array $response) use ($userId) {
                    return $this->storage->getLikes($userId)
                        ->then(
                            function (array $likes) use ($response) {
                                $response['likes'] = $likes;
                                return JsonResponse::ok($response);
                            }
                        );
                }
            )
            ->otherwise(
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                }
            );
    }
}
