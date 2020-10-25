<?php


namespace App\Authentication;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;
use function React\Promise\reject;


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
}
