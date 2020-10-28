<?php


namespace App\Posts\Controller\Output;


use App\Posts\Post as PostEntity;


final class Post
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var int $userId
     */
    public $userId;

    /**
     * @var int $likeCount
     */
    public $likeCount;

    /**
     * @var string $createdAt
     */
    public $createdAt;

    /**
     * @var Request
     */
    public $request;

    public function __construct(int $id, int $userId, int $likeCount, string $createdAt, Request $request)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->likeCount = $likeCount;
        $this->createdAt = $createdAt;
        $this->request = $request;
    }

    public static function fromEntity(PostEntity $post, Request $request)
    {
        return new self($post->id, $post->userId, $post->likeCount, $post->createdAt, $request);
    }
}
