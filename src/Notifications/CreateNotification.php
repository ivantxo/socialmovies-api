<?php


namespace App\Notifications;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class CreateNotification
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok([
            'message' => 'POST request to /notifications',
        ]);
    }
}
