<?php

namespace Api\routes;

use Api\controllers\AccountController;
use Slim\App;

return function (App $app) {
    // Define more routes here
    $app->post("/reset", AccountController::class . "::reset");
    $app->get("/balance", AccountController::class . "::getBalance");
};
