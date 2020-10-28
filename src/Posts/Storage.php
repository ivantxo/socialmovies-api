<?php


namespace App\Posts;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;


final class Storage
{
    /**
     * @var ConnectionInterface $connection
     */
    private $connection;

    /**
     * Storage constructor.
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(int $user_id, string $body, int $like_count): PromiseInterface
    {
        return $this->connection
            ->query('INSERT INTO posts (user_id, body, like_count) VALUES(?, ?, ?) ', [$user_id, $body, $like_count])
            ->then(
                function (QueryResult $result) {
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
            ->query('SELECT id, user_id, body, like_count, created_at FROM posts WHERE id = ?', [$id])
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
            ->query('SELECT id, user_id, body, like_count, created_at FROM posts')
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

    public function delete(int $id): PromiseInterface
    {
        return $this->connection
            ->query('DELETE FROM posts WHERE id = ?', [$id])
            ->then(
                function (QueryResult $result) {
                    if ($result->affectedRows === 0) {
                        throw new PostNotFound();
                    }
                }
            );
    }

    public function updateLikeCount(int $post_id, int $likeCount): PromiseInterface
    {
        return $this->connection
            ->query('UPDATE posts SET like_count = ? WHERE id = ?', [$likeCount, $post_id]);
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
