<?php


namespace App\Posts;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;


final class Storage
{
    /**
     * @var
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(int $user_id, int $like_count): PromiseInterface
    {
        return $this->connection
            ->query('INSERT INTO posts (user_id, like_count) VALUES(?, ?) ', [$user_id, $like_count])
            ->then(
                function (QueryResult $result) use ($user_id, $like_count) {
                    return $this->getById($result->insertId)
                        ->then(
                            function (Post $post) {
                                return $post;
                            }
                        );
                }
            );
    }

    public function getById(int $id): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, user_id, like_count, created_at FROM posts WHERE id = ?', [$id])
            ->then(
                function (QueryResult $result) {
                    if (empty($result->resultRows)) {
                        throw new PostNotFound();
                    }
                    return $this->mapPost($result->resultRows[0]);
                }
            );
    }

    public function getAll(): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, user_id, like_count, created_at FROM posts')
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
            (int)$row['like_count'],
            $row['created_at']
        );
    }
}
