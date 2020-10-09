<?php


namespace App\Movies;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class LinkMovie
{
    public function __invoke(ServerRequestInterface $request, int $userId)
    {
        return JsonResponse::ok([
            'message' => 'POST request to /linkmovie',
            'userId' => $userId,
        ]);
    }
}
