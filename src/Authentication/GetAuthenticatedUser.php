<?php


namespace App\Authentication;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class GetAuthenticatedUser
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /user',
        ]);
    }
}
