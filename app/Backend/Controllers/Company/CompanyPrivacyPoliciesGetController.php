<?php

namespace App\Backend\Controllers\Company;

use Slim\Views\Twig;
use Slim\Flash\Messages as Flash;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ServerRequestInterface;

final class CompanyPrivacyPoliciesGetController extends FrontController
{

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash)
    {
        parent::__construct($container, $twig, $flash);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Render index view
        return $this->twig->render($response, '@backend/company/company_privacy_policies.twig');
    }
}