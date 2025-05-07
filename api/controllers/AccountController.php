<?php
namespace Api\controllers;

use Api\db\AccountDataStore;
use Api\models\AccountModel;
use Api\utils\ControllerUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController
{
    public function reset(Request $request, Response $response): Response
    {
        AccountDataStore::reset();
        $response->getBody()->write("OK");
        return $response->withStatus(200);
    }

    public function getBalance(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $accountId = $queryParams["account_id"];

        $account = AccountDataStore::getAccountById($accountId);

        if (is_null($account)) {
            return ControllerUtils::jsonResponse($response, 0, 404);
        }

        return ControllerUtils::jsonResponse(
            $response,
            $account->getBalance(),
            200
        );
    }

    public function handleEvent(Request $request, Response $response): Response
    {
        $requestBody = $request->getBody()->getContents();
        $event = json_decode($requestBody, true);

        if (is_null($event)) {
            return ControllerUtils::jsonResponse(
                $response,
                [error => "Invalid JSON Body"],
                500
            );
        }

        $type = $event["type"] ?? null;
        $destination = $event["destination"] ?? null;
        $origin = $event["origin"] ?? null;
        $amount = $event["amount"] ?? 0;

        switch ($type) {
            case "deposit":
                $account = AccountDataStore::getAccountById($destination);

                if (is_null($account)) {
                    $account = new AccountModel(
                        id: $destination,
                        balance: $amount
                    );

                    AccountDataStore::createAccount($destination, $account);
                } else {
                    $account->deposit($amount);
                }

                AccountDataStore::updateAccount($account->getId(), $account);

                return ControllerUtils::jsonResponse($response, [
                    "destination" => [
                        "id" => $account->getId(),
                        "balance" => $account->getBalance(),
                    ],
                ]);
            case "withdraw":
                $account = AccountDataStore::getAccountById($origin);

                if (is_null($account) || $account->getBalance() < $amount) {
                    return ControllerUtils::jsonResponse($response, 0, 404);
                }

                $account->withdraw($amount);

                AccountDataStore::updateAccount($account->getId(), $account);

                return ControllerUtils::jsonResponse($response, [
                    "origin" => [
                        "id" => $account->getId(),
                        "balance" => $account->getBalance(),
                    ],
                ]);
            case "transfer":
                $originAccount = AccountDataStore::getAccountById($origin);
                $destinationAccount = AccountDataStore::getAccountById(
                    $destination
                );

                if (is_null($originAccount)) {
                    return ControllerUtils::jsonResponse($response, 0, 404);
                }

                if (is_null($destinationAccount)) {
                    $destinationAccount = new AccountModel(
                        id: $destination,
                        balance: $amount
                    );

                    AccountDataStore::createAccount(
                        $destination,
                        $destinationAccount
                    );
                }

                $originAccount->transferTo($destination, $amount);

                AccountDataStore::updateAccount(
                    $originAccount->getId(),
                    $originAccount
                );

                AccountDataStore::updateAccount(
                    $destinationAccount->getId(),
                    $destinationAccount
                );

                return ControllerUtils::jsonResponse($response, [
                    "origin" => [
                        "id" => $originAccount->getId(),
                        "balance" => $originAccount->getBalance(),
                    ],
                    "destination" => [
                        "id" => $destinationAccount->getId(),
                        "balance" => $destinationAccount->getBalance(),
                    ],
                ]);
            default:
                return ControllerUtils::jsonResponse(
                    $response,
                    ["error" => "Unknown event type"],
                    404
                );
        }
    }
}
?>
