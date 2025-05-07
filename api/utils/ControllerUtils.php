<?php

namespace Api\utils;

use Psr\Http\Message\ResponseInterface as Response;

class ControllerUtils
{
    /**
     * @param array<int,mixed> $data
     */
    public static function jsonResponse(
        Response $response,
        array $data,
        int $status = 200
    ): Response {
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus($status);
    }
}
?>
