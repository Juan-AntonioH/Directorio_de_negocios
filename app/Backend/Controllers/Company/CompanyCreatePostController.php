<?php

namespace App\Backend\Controllers\Company;

use App\Backend\Repositories\CompanyRepository;
use App\Backend\Repositories\UserRepository;
use App\Backend\Services\CompanyService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;



final class CompanyCreatePostController extends PostController
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
        $validation = $this->validator->validate($request, [
            'name' => v::notEmpty(),
            'direction' => v::notEmpty(),
            'phone' => v::intVal()->notEmpty(),
            'email' => V::email()->noWhitespace()->notEmpty(),
            'url' => v::url()->noWhitespace()->notEmpty(),
            'description' => v::notEmpty(),
            'provincia' => v::intVal()->notEmpty()
        ]);

        if ($validation->failed()) {
            $this->flash->addMessage('error', 'Rellena todos los campos correctamente');
            return is_null($args['id']) ? RouteHelpers::redirect($request, $response, 'company.get.create')           
                : RouteHelpers::redirect($request, $response, 'company.get.edit',['id' => $args['id']]);
        }

        $active = $request->getParsedBody()['active'] == NULL ? 0 : 1;

        if(!$this->companyService->save([
            'name' => $request->getParsedBody()['name'],
            'direction' => $request->getParsedBody()['direction'],
            'phone' => $request->getParsedBody()['phone'],
            'email' => $request->getParsedBody()['email'],
            'url' => $request->getParsedBody()['url'],
            'description' => $request->getParsedBody()['description'],
            'active' => $active,
            'provincia' => $request->getParsedBody()['provincia']
        ],$args['id'])){
            $this->flash->addMessage('error', 'Ocurrio un error inesperado');
        }

        $texto = is_null($args['id']) ? "Se añadio correctamente tú empresa": "Se modificó los datos con existo";

        $this->flash->addMessage('success', $texto);

        return RouteHelpers::redirect($request, $response, 'dashboard');
    }
}