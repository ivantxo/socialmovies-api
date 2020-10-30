<?php


namespace App\Users;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;


use App\Posts\Post;


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

    public function getPosts(int $userId): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, user_id, body, like_count, created_at FROM posts WHERE user_id = ?', [$userId])
            ->then(
                function (QueryResult $result) {
                    return array_map(
                        function ($row) {
                            return $this->mapPost($row);
                        },
                        $result->resultRows
                    );
                }
            );
    }

    private function mapPost(array $row): Post
    {
        return new Post(
            (int)$row['id'],
            (int)$row['user_id'],
            (int)$row['body'],
            (int)$row['like_count'],
            $row['created_at']
        );
    }
}
