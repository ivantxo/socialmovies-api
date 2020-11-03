<?php


namespace App\Authentication;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function React\Promise\reject;


use App\Posts\Storage as Posts;
use App\Likes\Storage as Likes;


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

    public function create(string $email, string $password): PromiseInterface
    {
        return $this->connection->query(
            'INSERT INTO users (email, password) VALUES (?, ?)', [$email, $password]
        );
    }

    public function getByEmail(string $email): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, email, password FROM users WHERE email = ?', [$email])
            ->then(
                function (QueryResult $result) {
                    if (empty($result->resultRows)) {
                        throw new UserNotFound();
                    }
                    $row = $result->resultRows[0];
                    return new User((int)$row['id'], $row['email'], $row['password']);
                }
            );
    }

    public function getByUserId(int $useId): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, email, password FROM users WHERE id = ?', [$useId])
            ->then(
                function (QueryResult $result) {
                    if (empty($result->resultRows)) {
                        throw new UserNotFound();
                    }
                    $row = $result->resultRows[0];
                    return new User((int)$row['id'], $row['email'], $row['password']);
                }
            );
    }

    public function getPosts(int $userId): PromiseInterface
    {
        $posts = new Posts($this->connection);
        return $posts->getByUserId($userId);
    }

    public function getLikes(int $userId): PromiseInterface
    {
        $likes = new Likes($this->connection);
        return $likes->getByUserId($userId);
    }
}
