<?php

namespace Api\controllers;

use Api\db\AccountDataStore;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController
{
    public function reset(
        Request $request,
        Response $response,
        mixed $args
    ): Response {
        AccountDataStore::reset();
        $response->getBody()->write("OK");
        return $response->withStatus(200);
    }

    public function getBalance(Request $request, Response $response, mixed $args) {}
    public function handleEvent(Request $request, Response $response, mixed $args) {}
}

?>
