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

    public function getBalance(
        Request $request,
        Response $response,
        mixed $args
    ): Response {
        $queryParams = $request->getQueryParams();
        $accountId = $queryParams["account_id"];

        $account = AccountDataStore::getAccountById($accountId);

        if (is_null($account)) {
            $response->getBody()->write(0);
            return $response->withStatus(404);
        }

        $response->getBody()->write(json_encode($account->getBalance()));

        return $response
            ->withHeader("Content-Type", "application/json")
            ->withStatus(200);
    }
    public function handleEvent(
        Request $request,
        Response $response,
        mixed $args
    ): void {}
}

?>
