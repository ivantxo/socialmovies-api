<?php


namespace App\Posts\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Posts\Controller\Output\Request;
use App\Posts\PostNotFound;
use App\Posts\Storage;


final class DeletePost
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, string $id)
    {
        return $this->storage->delete((int)$id)
            ->then(
                function () {
                    $response = [
                        'request' => Request::createPost(),
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
