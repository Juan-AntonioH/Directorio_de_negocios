<?php

namespace App\Shared\Controllers;

use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages as Flash;

class PostController
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var Validator
     */
    protected $validator;
    /**
     * @var Flash
     */
    protected $flash;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash)
    {
        $this->container = $container;
        $this->validator = $validator;
        $this->flash = $flash;
    }
}
