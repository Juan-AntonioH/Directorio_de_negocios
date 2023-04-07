<?php

namespace App\Backend\Controllers\Users;

use App\Backend\Repositories\RoleRepository;
use App\Shared\Controllers\FrontController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class UsersCreateInvitationGetController extends FrontController
{
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, RoleRepository $roleRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->roleRepository = $roleRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $roles = $this->roleRepository->findAll();

        // Render index view
        return $this->twig->render($response, '@backend/users/create_user_invitation.twig', [
            'roles' => $roles,
        ]);
    }
}
