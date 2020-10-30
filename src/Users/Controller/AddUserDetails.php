<?php


namespace App\Users\Controller;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class AddUserDetails
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok([
            'message' => 'POST request to /users',
        ]);
    }
}
