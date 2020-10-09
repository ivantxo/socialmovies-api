<?php

namespace App\Likes;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class Like
{
    public function __invoke(ServerRequestInterface $request, int $postId)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /like',
            'postId' => $postId,
        ]);
    }
}
