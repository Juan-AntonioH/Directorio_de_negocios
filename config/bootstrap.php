<?php

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Respect\Validation\Factory;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

// Set up dotenv
$dotenv = Dotenv::createImmutable(realpath(__DIR__ . '/../'));
$dotenv->load();

$containerBuilder = new ContainerBuilder();

// Add DI container definitions
$containerBuilder->addDefinitions(__DIR__ . '/container.php');

// Create DI container instance
$container = $containerBuilder->build();

// Create Slim App instance
$app = $container->get(App::class);

// Register routes
(require __DIR__ . '/routes.php')($app);

// Register middleware
(require __DIR__ . '/middleware.php')($app);

// Register custom validators
Factory::setDefaultInstance(
    (new Factory())
        ->withRuleNamespace('App\\Shared\\Validation\\Rules')
        ->withRuleNamespace('App\\Backend\\Validation\\Rules')
        ->withRuleNamespace('App\\Frontend\\Validation\\Rules')
        ->withExceptionNamespace('App\\Shared\\Validation\\Exceptions')
        ->withExceptionNamespace('App\\Backend\\Validation\\Rules')
        ->withExceptionNamespace('App\\Frontend\\Validation\\Rules')
);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $container->get(Twig::class)));

return $app;
