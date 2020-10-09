<?php


namespace App\Core;


use React\Http\Message\Response;


final class JsonResponse
{
    private static function response(int $statusCode, $data = null): Response
    {
        $body = $data ? json_encode($data) : '';
        return new Response(
            $statusCode,
            ['Content-type' => 'application/json'],
            $body
        );
    }

    public static function ok($data = null): Response
    {
        return self::response(200, $data);
    }

    public static function internalServerError(string $reason): Response
    {
        return self::response(500, ['messsage' => $reason]);
    }
}
