<?php
namespace App\Backend\Controllers\Company;

use App\Backend\Repositories\ProvinciaRepository;
use Slim\Views\Twig;
use Slim\Flash\Messages as Flash;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ServerRequestInterface;

final class CompanyCreateGetController extends FrontController
{
    private ProvinciaRepository $provinciaRepository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, ProvinciaRepository $provinciaRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->provinciaRepository = $provinciaRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $provincias = $this->provinciaRepository->findAll();
        // Render index view
        return $this->twig->render($response, '@backend/company/company_create-edit.twig',[
            'provincias' => $provincias
        ]);
    }
}