<?php

namespace App\Backend\Controllers\Company;

use App\Backend\Repositories\CompanyRepository;
use App\Backend\Services\CompanyService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;



final class CompanyDeletePostController extends PostController
{
    private CompanyService $companyService;

    private CompanyRepository $companyRepository;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash, CompanyService $companyService, CompanyRepository $companyRepository)
    {
        parent::__construct($container, $validator, $flash);
        $this->companyService = $companyService;
        $this->companyRepository = $companyRepository;

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $company = $this->companyRepository->find($args['id']);

        if($_SESSION['user'] != $company->id_creator){
            $this->flash->addMessage('error', 'Deja de intentar choricear las empresas de otros');
            return RouteHelpers::redirect($request, $response, 'dashboard');
        }

        if(!intval($args['id'])){
            $this->flash->addMessage('error', 'No se ha seleccionado ninguna empresa');
            return RouteHelpers::redirect($request, $response, 'dashboard');
        }

        if(!$this->companyService->delete(intval($args['id']))){
            $this->flash->addMessage('error', 'Ocurrió un error inesperado');
            return RouteHelpers::redirect($request, $response, 'dashboard');
        }
        
        $this->flash->addMessage('success', 'Se eliminó con exito el registro');
        return RouteHelpers::redirect($request, $response, 'dashboard');
    }
}
