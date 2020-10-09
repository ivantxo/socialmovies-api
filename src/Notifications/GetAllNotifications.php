<?php


namespace App\Notifications;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class GetAllNotifications
{
    public function __invoke(ServerRequestInterface $request)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /notifications',
        ]);
    }
}
