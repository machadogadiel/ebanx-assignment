<?php
use Slim\Factory\AppFactory;

require __DIR__ . "/vendor/autoload.php";

// slim instance
$app = AppFactory::create();

// error handler middleware
$app->addErrorMiddleware(true, false, false);

// pass slim instance to routes callback to set up routes
$routes = require __DIR__ . "/api/routes/routes.php";
$routes($app);

// self-explanatory...
$app->run();
?>
