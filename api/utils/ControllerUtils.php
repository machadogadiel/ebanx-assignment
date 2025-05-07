<?php

namespace Api\utils;

use Psr\Http\Message\ResponseInterface as Response;

class ControllerUtils
{
    /**
     * Returns a JSON response with appropriate headers
     *
     * @param Response $response The PSR-7 response object
     * @param mixed $data The data to encode as JSON
     * @param int $status The HTTP status code
     * @return Response
     */
    public static function jsonResponse(
        Response $response,
        mixed $data,
        int $status = 201
    ): Response {
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus($status);
    }
}
?>
