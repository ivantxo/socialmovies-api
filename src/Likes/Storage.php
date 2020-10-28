<?php


namespace App\Likes;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;


use App\Posts\Post;
use App\Posts\PostNotFound;
use App\Posts\Storage as Posts;


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
            ->query('INSERT INTO likes (post_id, user_id) VALUES (?, ?)', [$post_id, $user_id]);
    }

    public function getPost(int $post_id): PromiseInterface
    {
        $posts = new Posts($this->connection);
        return $posts->getById($post_id)
            ->then(
                function (Post $post) {
                    return $post;
                }
            )
            ->otherwise(
                function () {
                    throw new PostNotFound();
                }
            );
    }

    public function updateLikeCount(int $postId, int $likeCount): PromiseInterface
    {
        $posts = new Posts($this->connection);
        return $posts->updateLikeCount($postId, $likeCount);
    }
}
