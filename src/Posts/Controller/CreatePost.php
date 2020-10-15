<?php


namespace App\Posts\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class CreatePost
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok([
            'message' => 'POST request to /post',
        ]);
    }
}
