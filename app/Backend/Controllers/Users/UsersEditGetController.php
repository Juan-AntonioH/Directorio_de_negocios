<?php

namespace App\Backend\Controllers\Users;

use App\Backend\Repositories\RoleRepository;
use App\Backend\Repositories\UserRepository;
use App\Shared\Controllers\FrontController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class UsersEditGetController extends FrontController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, UserRepository $userRepository, RoleRepository $roleRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $user = $this->userRepository->find($args['id_user']);
        $roles = $this->roleRepository->findAll();

        // Render index view
        return $this->twig->render($response, '@backend/users/edit_user.twig', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }
}
