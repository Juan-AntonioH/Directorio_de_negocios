<?php

namespace App\Shared\Middlewares;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Csrf\Guard;
use Slim\Views\Twig;

final class CsrfViewMiddleware extends BaseMiddleware
{
    /**
     * @var Guard
     */
    private $csrf;

    public function __construct(ContainerInterface $container, Twig $twig)
    {
        $this->csrf = $container->get('csrf');
        parent::__construct($container, $twig);
    }

    public function __invoke(ServerRequestInterface $request, RequestHandler $handler): ResponseInterface
    {
        $this->twig->getEnvironment()->addGlobal('csrf', [
            'field' => '
                <input type="hidden" name="' . $this->csrf->getTokenNameKey() . '" value="' . $this->csrf->getTokenName() . '">
                <input type="hidden" name="' . $this->csrf->getTokenValueKey() . '" value="' . $this->csrf->getTokenValue() . '">
            ',
        ]);

        return $handler->handle($request);
    }
}
