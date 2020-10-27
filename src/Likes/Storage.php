<?php


namespace App\Likes;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;


use App\Posts\Storage as Posts;
use App\Posts\Post;


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

    public function create(int $post_id, int $user_id): PromiseInterface
    {
        return $this->connection
            ->query('INSERT INTO likes (post_id, user_id) VALUES (?, ?)', [$post_id, $user_id])
            ->then(
                function (QueryResult $result) use ($post_id) {
                    $posts = new Posts($this->connection);
                    return $posts->getById($post_id)
                        ->then(
                            function (Post $post) use ($posts) {
                                $post_id = $post->id;
                                $like_count = $post->like_count + 1;
                                return $posts->updateLikeCount($post_id, $like_count);
                            }
                        );
                }
            );
    }
}
