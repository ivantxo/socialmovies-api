<?php

namespace App\Posts;


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
     * @var string $body
     */
    public $body;

    /**
     * @var int $likeCount
     */
    public $likeCount;

    /**
     * @var string $created_at
     */
    public $createdAt;

    public function __construct(int $id, int $userId, string $body, int $likeCount, string $createdAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->body = $body;
        $this->likeCount = $likeCount;
        $this->createdAt = $createdAt;
    }
}
