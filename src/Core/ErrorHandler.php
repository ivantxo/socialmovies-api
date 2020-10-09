<?php


namespace App\Core;


use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
use \Throwable;


use App\Core\JsonResponse;


final class ErrorHandler
{
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        try {
            return $next($request);
        } catch (Throwable $error) {
            echo '--------------Error--------------' . PHP_EOL
                . $error->getTraceAsString() . PHP_EOL;
            return JsonResponse::internalServerError($error->getMessage());
        }
    }
}
