<?php


namespace App\Posts;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class DeletePost
{
    public function __invoke(ServerRequestInterface $request, int $postId)
    {
        return JsonResponse::ok([
            'message' => 'DELETE request to /post',
            'postId' => $postId,
        ]);
    }
}
