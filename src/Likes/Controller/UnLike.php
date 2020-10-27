<?php

namespace App\Likes\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class UnLike
{
    public function __invoke(ServerRequestInterface $request, int $postId)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /unlike',
            'postId' => $postId,
        ]);
    }
}
