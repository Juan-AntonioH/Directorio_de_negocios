<?php
namespace App\Backend\Controllers\Company;

use App\Backend\Repositories\CompanyRepository;
use App\Backend\Repositories\ProvinciaRepository;
use Slim\Views\Twig;
use Slim\Flash\Messages as Flash;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ServerRequestInterface;

final class CompanyEditGetController extends FrontController
{
    private ProvinciaRepository $provincia_repsitory;
    private CompanyRepository $company_repository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, ProvinciaRepository $provinciaRepository, CompanyRepository $companyRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->provincia_repsitory = $provinciaRepository;
        $this->company_repository = $companyRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $provincias = $this->provincia_repsitory->findAll();
        $company = $this->company_repository->find($args['id']);
        // Render index view
        return $this->twig->render($response, '@backend/company/company_create-edit.twig',[
            'provincias' => $provincias,
            'company' => $company
        ]);
    }
}