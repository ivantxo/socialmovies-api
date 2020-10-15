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

    /**
     * @var Request
     */
    public $request;

    public function __construct(int $id, int $user_id, int $like_count, string $created_at, Request $request)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->like_count = $like_count;
        $this->created_at = $created_at;
        $this->request = $request;
    }

    public static function fromEntity(PostEntity $post, Request $request)
    {
        return new self($post->id, $post->user_id, $post->like_count, $post->created_at, $request);
    }
}
