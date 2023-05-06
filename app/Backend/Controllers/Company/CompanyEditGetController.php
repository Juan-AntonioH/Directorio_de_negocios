<?php
namespace App\Backend\Controllers\Company;

use Slim\Views\Twig;
use Slim\Flash\Messages as Flash;
use App\Shared\Helpers\RouteHelpers;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ServerRequestInterface;
use App\Backend\Repositories\CompanyRepository;
use App\Backend\Repositories\ProvinciaRepository;

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

        if($_SESSION['user'] != $company->id_creator){
            $this->flash->addMessage('error', 'Deja de intentar choricear las empresas de otros');
            return RouteHelpers::redirect($request, $response, 'dashboard');
        }

        if(!intval($args['id'])){
            $this->flash->addMessage('error', 'No se ha seleccionado ninguna empresa');
            return RouteHelpers::redirect($request, $response, 'dashboard');
        }
        // Render index view
        return $this->twig->render($response, '@backend/company/company_create-edit.twig',[
            'provincias' => $provincias,
            'company' => $company
        ]);
    }
}