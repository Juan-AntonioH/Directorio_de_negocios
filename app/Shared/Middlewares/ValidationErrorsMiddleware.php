<?php

namespace App\Shared\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class ValidationErrorsMiddleware extends BaseMiddleware
{
    public function __invoke(ServerRequestInterface $request, RequestHandler $handler): ResponseInterface
    {
        if (isset($_SESSION['errors'])) {
            $this->twig->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
            unset($_SESSION['errors']);
        }

        return $handler->handle($request);
    }
}
