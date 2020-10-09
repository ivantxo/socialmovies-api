<?php


namespace App\Notifications;


use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;


final class DeleteNotification
{
    public function __invoke(ServerRequestInterface $request, int $notificationId)
    {
        return JsonResponse::ok([
            'message' => 'DELETE request to /notifications',
            'notificationId' => $notificationId,
        ]);
    }
}
