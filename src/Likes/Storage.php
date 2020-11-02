<?php


namespace App\Likes;


use React\MySQL\ConnectionInterface;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;


use App\Posts\Post;
use App\Posts\PostNotFound;
use App\Posts\Storage as Posts;
use App\Notifications\Storage as Notifications;


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

    public function create(int $postId, int $userId): PromiseInterface
    {
        return $this->connection
            ->query('INSERT INTO likes (post_id, user_id) VALUES (?, ?)', [$postId, $userId]);
    }

    public function delete(int $postId, int $userId): PromiseInterface
    {
        return $this->connection
            ->query(
                'DELETE FROM likes WHERE post_id = ? AND user_id = ? ORDER BY created_at DESC LIMIT 1',
                [$postId, $userId]
            );
    }

    public function likeExists(int $postId, int $userId): PromiseInterface
    {
        return $this->connection
            ->query('SELECT id, post_id, user_id FROM likes WHERE post_id = ? AND user_id =  ?', [$postId, $userId])
            ->then(
                function (QueryResult $result) {
                    if (empty($result->resultRows)) {
                        throw new LikeNotFound();
                    }
                    return true;
                }
            );
    }

    public function getPost(int $postId): PromiseInterface
    {
        $posts = new Posts($this->connection);
        return $posts->getById($postId)
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

    public function createNotification(Post $post, int $userId): PromiseInterface
    {
        $notifications = new Notifications($this->connection);
        return $notifications->create($post->id, $userId, $post->userId, 'like');
    }

    public function deleteNotification(Post $post, int $userId): PromiseInterface
    {
        $notifications = new Notifications($this->connection);
        return $notifications->delete($post->id, $userId, $post->userId, 'like');
    }
}
