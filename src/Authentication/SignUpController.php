<?php


namespace App\Authentication;


use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;


final class SignUpController
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['message' => 'POST request to /auth/signup'])
        );
    }
}
