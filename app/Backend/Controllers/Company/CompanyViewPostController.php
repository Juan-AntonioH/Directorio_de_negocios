<?php

namespace App\Backend\Controllers\Company;

use Slim\Flash\Messages as Flash;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Controllers\PostController;
use App\Backend\Services\PopularityService;
use Psr\Http\Message\ServerRequestInterface;
use App\Backend\Repositories\PopularityRepository;



final class CompanyViewPostController extends PostController
{
    private PopularityService $popularityService;

    private popularityRepository $popularityRepository;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash, PopularityService $popularityService, popularityRepository $popularityRepository)
    {
        parent::__construct($container, $validator, $flash);
        $this->popularityService = $popularityService;
        $this->popularityRepository = $popularityRepository;

    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $valoracion = intval($request->getParsedBody()['valorar']);

        if(!($valoracion >= 1 && $valoracion <= 5)){
            $this->flash->addMessage('error', 'Ocurrió un error al valorar');
        }else{
            $datos = [
                'id_user'=> $_SESSION['user'],
                'id_company' => $args['id'],
                'vote' => $valoracion
            ];

            if($this->popularityService->save($datos)){
                $this->flash->addMessage('success', 'La valoración se efectuó correctamente');
            }else{
                $this->flash->addMessage('error', 'Ocurrió un error inesperado');
            };          
        }

        return RouteHelpers::redirect($request, $response, 'company.get.view',['id' => $args['id']]);
    }
}
