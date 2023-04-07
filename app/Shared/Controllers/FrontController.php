<?php

namespace App\Shared\Controllers;

use Psr\Container\ContainerInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

class FrontController
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var Twig
     */
    protected $twig;
    /**
     * @var Flash
     */
    protected $flash;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash)
    {
        $this->container = $container;
        $this->twig = $twig;
        $this->flash = $flash;
    }
}
