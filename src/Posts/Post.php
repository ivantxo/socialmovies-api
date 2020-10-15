<?php

namespace App\Posts;


final class Post
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var int $user_id
     */
    public $user_id;

    /**
     * @var int $like_count
     */
    public $like_count;

    /**
     * @var string $created_at
     */
    public $created_at;

    public function __construct(int $id, int $user_id, int $like_count, string $created_at)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->like_count = $like_count;
        $this->created_at = $created_at;
    }
}
