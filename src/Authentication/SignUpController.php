<?php


namespace App\Authentication;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class SignUpController
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok(['message' => 'POST request to /auth/signup']);
    }
}
