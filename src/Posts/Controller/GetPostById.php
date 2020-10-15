<?php


namespace App\Posts\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class GetPostById
{
    public function __invoke(ServerRequestInterface $request, int $postId)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /posts',
            'postId' => $postId,
        ]);
    }
}
