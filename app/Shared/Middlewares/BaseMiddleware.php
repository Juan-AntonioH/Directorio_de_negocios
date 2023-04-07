<?php

namespace App\Shared\Middlewares;

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

class BaseMiddleware
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var Twig
     */
    protected $twig;

    public function __construct(ContainerInterface $container, Twig $twig)
    {
        $this->container = $container;
        $this->twig = $twig;
    }
}
