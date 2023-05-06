<?php

namespace App\Backend\Controllers\Company;

use Slim\Views\Twig;
use Slim\Flash\Messages as Flash;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ServerRequestInterface;
use App\Backend\Repositories\CompanyRepository;
use App\Backend\Repositories\ProvinciaRepository;

final class CompanyPopularityGetController extends FrontController
{
    private CompanyRepository $companyRepository;
    private ProvinciaRepository $provinciaRepository;
    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, CompanyRepository $companyRepository, ProvinciaRepository $provinciaRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->companyRepository = $companyRepository;
        $this->provinciaRepository = $provinciaRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $companies = $this->companyRepository->findCompaniesPopularity(20);
        $provincias = $this->provinciaRepository->findAll();
        // Render index view
        return $this->twig->render($response, '@backend/company/company_popularity.twig',[
            'companies' => $companies,
            'provincias' => $provincias
        ]);
    }
}