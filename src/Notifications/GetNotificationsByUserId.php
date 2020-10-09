<?php


namespace App\Notifications;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class GetNotificationsByUserId
{
    public function __invoke(ServerRequestInterface $request, int $userId)
    {
        return JsonResponse::ok([
            'message' => 'GET request to /notifications',
            'userId' => $userId,
        ]);
    }
}
