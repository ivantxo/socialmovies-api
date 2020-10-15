<?php


namespace App\Posts\Controller\Output;


final class Request
{
    private const URI = 'http://localhost:8000/posts/';

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $url;

    /**
     * @var array|null
     */
    public $body;

    public function __construct(string $type, string $url, array $body = null)
    {
        $this->type = $type;
        $this->url = $url;
        $this->body = $body;
    }

    public static function detailedProduct(int $id): self
    {
        return new self('GET', self::URI . $id);
    }

    public static function updateProduct(int $id): self
    {
        return new self('PUT', self::URI . $id);
    }

    public static function listOfProducts(): self
    {
        return new self('GET', self::URI);
    }

    public static function createProduct(): self
    {
        return new self(
            'POST',
            self::URI,
            [
                'id' => 'int',
                'user_id' => 'int',
                'like_count' => 'int',
                'created_at' => 'datetime',
            ]
        );
    }
}
