<?php

namespace App\Backend\Controllers\Users;

use App\Backend\Repositories\UserInvitationRepository;
use App\Backend\Repositories\UserRepository;
use App\Shared\Controllers\FrontController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class UsersListGetController extends FrontController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserInvitationRepository
     */
    private $userInvitationRepository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, UserRepository $userRepository, UserInvitationRepository $userInvitationRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->userRepository = $userRepository;
        $this->userInvitationRepository = $userInvitationRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $users = $this->userRepository->findAll();

        $invitations = $this->userInvitationRepository->findAllWhere('WHERE id_user IS NULL');

        // Render index view
        return $this->twig->render($response, '@backend/users/users_list.twig', [
            'users' => $users,
            'invitations' => $invitations,
        ]);
    }
}
