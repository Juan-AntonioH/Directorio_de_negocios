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

final class CompanyViewGetController extends FrontController
{
    private CompanyRepository $companyRepsitory;
    private ProvinciaRepository $provinciaRepository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, CompanyRepository $companyRepository, ProvinciaRepository $provinciaRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->companyRepsitory = $companyRepository;
        $this->provinciaRepository = $provinciaRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $company = $this->companyRepsitory->find($args['id']);
        $company->provincia = $this->provinciaRepository->find($company->provincia)->name;
        // Render index view
        return $this->twig->render($response, '@backend/company/company_view.twig',[
            'company' => $company
        ]);
    }
}