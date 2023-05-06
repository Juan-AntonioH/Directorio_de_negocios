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
use App\Backend\Repositories\PopularityRepository;

final class CompanyViewGetController extends FrontController
{
    private CompanyRepository $companyRepsitory;
    private ProvinciaRepository $provinciaRepository;
    private PopularityRepository $popularityRepository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, CompanyRepository $companyRepository, ProvinciaRepository $provinciaRepository, PopularityRepository $popularityRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->companyRepsitory = $companyRepository;
        $this->provinciaRepository = $provinciaRepository;
        $this->popularityRepository = $popularityRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $company = $this->companyRepsitory->find($args['id']);
        $company->provincia = $this->provinciaRepository->find($company->provincia)->name;
        $popularity = $this->popularityRepository->findAllPopularities($args['id']);
        // Render index view
        return $this->twig->render($response, '@backend/company/company_view.twig',[
            'company' => $company,
            'popularity' => $popularity
        ]);
    }
}