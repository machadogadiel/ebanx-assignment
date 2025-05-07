<?php


namespace Api\controllers;

use Api\db\AccountDataStore;
use Api\utils\ControllerUtils;
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

        return ControllerUtils::jsonResponse($response, $account->getBalance())
    }

    public function handleEvent(
        Request $request,
        Response $response,
        mixed $args
    ): Response {

    }
}

?>
