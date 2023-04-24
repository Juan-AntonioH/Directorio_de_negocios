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

final class CompanyListGetController extends FrontController
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
        if($args !=null){
            $companies = $this->companyRepository->findCompaniesUser($args['id']);
        }else{
            $companies = $this->companyRepository->findCompanies();
        }
        $provincias = $this->provinciaRepository->findAll();
        // Render index view
        return $this->twig->render($response, '@backend/company/company_list.twig',[
            'companies' => $companies,
            'provincias' => $provincias
        ]);
    }
}