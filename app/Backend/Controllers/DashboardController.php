<?php

namespace App\Backend\Controllers;

use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DashboardController extends FrontController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Render index view
        return $this->twig->render($response, '@backend/dashboard.twig');
    }
}
