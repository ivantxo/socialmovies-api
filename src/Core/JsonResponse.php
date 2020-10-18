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

    public static function created($data): Response
    {
        return self::response(201, $data);
    }

    public static function badRequest(array $errors): Response
    {
        return self::response(400, ['errors' => $errors]);
    }

    public static function unauthorised(): Response
    {
        return self::response(401);
    }

    public static function notFound(): Response
    {
        return self::response(404);
    }

    public static function noContent(): Response
    {
        return self::response(204);
    }
}
