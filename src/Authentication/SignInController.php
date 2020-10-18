<?php


namespace App\Authentication;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class SignInController
{
    public function __invoke(ServerRequestInterface $request)
    {
        $user = [
            'email' => $request->getParsedBody()['email'],
            'password' => $request->getParsedBody()['password'],
        ];
        return JsonResponse::ok([
            'message' => 'POST request to /auth/signin',
            'user' => $user,
        ]);
    }
}