<?php

namespace App\Notifications\Controller;


use Exception;
use Psr\Http\Message\ServerRequestInterface;


use App\Core\JsonResponse;
use App\Notifications\Storage;


final class MarkNotificationsRead
{
    /**
     * @var Storage $storage
     */
    private $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    public function __invoke(ServerRequestInterface $request, int $notificationId)
    {
        return $this->storage->markRead($notificationId)
            ->then(
                function () {
                    return JsonResponse::ok([
                        'message' => 'Notification marked read',
                    ]);
                }
            )
            ->otherwise(
                function (Exception $exception) {
                    return JsonResponse::internalServerError($exception->getMessage());
                }
            );
    }
}
