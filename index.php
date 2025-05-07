<?php
use Slim\Factory\AppFactory;

require __DIR__ . "/vendor/autoload.php";

// slim instance
$app = AppFactory::create();

// error handler middleware
$app->addErrorMiddleware(true, false, false);

// self-explanatory...
$app->run();
?>
