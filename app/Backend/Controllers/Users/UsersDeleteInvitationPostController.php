<?php

namespace App\Backend\Controllers\Users;

use App\Backend\Repositories\UserInvitationRepository;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;

final class UsersDeleteInvitationPostController extends PostController
{
    /**
     * @var UserInvitationRepository
     */
    private $userInvitationRepository;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash, UserInvitationRepository $userInvitationRepository)
    {
        parent::__construct($container, $validator, $flash);
        $this->userInvitationRepository = $userInvitationRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $invitation = $this->userInvitationRepository->find($args['id_invitation']);

        if (!$invitation) {
            $this->flash->addMessage('error', 'No se ha encontrado la invitación que deseas eliminar');

            return RouteHelpers::redirect($request, $response, 'users.list');
        }

        $this->userInvitationRepository->delete($invitation);
        $this->flash->addMessage('success', 'Invitación eliminada correctamente');

        return RouteHelpers::redirect($request, $response, 'users.list');
    }
}
