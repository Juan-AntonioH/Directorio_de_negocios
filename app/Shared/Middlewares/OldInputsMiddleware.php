<?php

namespace App\Shared\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class OldInputsMiddleware extends BaseMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (isset($_SESSION['old'])) {
            $this->twig->getEnvironment()->addGlobal('old', $_SESSION['old']);
            unset($_SESSION['old']);
        }

        $_SESSION['old'] = $request->getParsedBody();

        return $handler->handle($request);
    }
}
