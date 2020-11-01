<?php


namespace App\Notifications;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
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
}
