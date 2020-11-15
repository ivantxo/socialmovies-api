<?php


namespace App\Notifications;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\Promise;
use React\Promise\PromiseInterface;


final class Storage
{
    /**
     * @var ConnectionInterface $connection
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(int $postId, int $senderId, int $recipientId, string $type)
    {
        return $this->connection
            ->query(
                'INSERT INTO notifications (post_id, sender, recipient, was_read, type) VALUES (?, ?, ?, ?, ?)',
                [$postId, $senderId, $recipientId, false, $type]
            );
    }

    public function delete(int $postId, int $senderId, int $recipientId, string $type)
    {
        return $this->connection
            ->query(
                'DELETE FROM notifications WHERE post_id = ? AND sender = ? AND recipient = ? AND type = ?',
                [$postId, $senderId, $recipientId, $type]
            );
    }

    public function markRead(int $notificationId)
    {
        return $this->connection
            ->query(
                'UPDATE notifications SET was_read = TRUE WHERE id = ?',
                [$notificationId]
            );
    }
}
