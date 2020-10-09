<?php


namespace App\Posts;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class GetAllPosts
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /posts',
        ]);
    }
}
