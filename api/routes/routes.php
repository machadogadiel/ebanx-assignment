<?php

namespace Api\routes;

use Api\controllers\AccountController;
use Slim\App;

return function (App $app) {
    $app->get("/", function ($request, $response, $name) {
        $response->getBody()->write("API is running!");

        return $response;
    });
    // Define more routes here
    $app->post("/reset", [AccountController::class, "reset"]);
    $app->get("/balance", [AccountController::class, "getBalance"]);
    $app->post("/event", [AccountController::class, "handleEvent"]);
};
