<?php


namespace App\Users;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class GetUserDetails
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /users',
        ]);
    }
}
