<?php

namespace App\Backend\Controllers\Users;

use App\Backend\Repositories\RoleRepository;
use App\Backend\Repositories\UserInvitationRepository;
use App\Backend\Repositories\UserRepository;
use App\Backend\Services\InvitationUserService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;

final class UsersCreateInvitationPostController extends PostController
{
    /**
     * @var InvitationUserService
     */
    private $invitationUserService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var UserInvitationRepository
     */
    private $userInvitationRepository;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash)
    {
        parent::__construct($container, $validator, $flash);
        $this->invitationUserService = $this->container->get(InvitationUserService::class);
        $this->userRepository = $this->container->get(UserRepository::class);
        $this->roleRepository = $this->container->get(RoleRepository::class);
        $this->userInvitationRepository = $this->container->get(UserInvitationRepository::class);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $validation = $this->validator->validate($request, [
            'username' => v::notEmpty(),
            'email' => v::emailInvitationAvailable($this->userInvitationRepository)->emailAvailable($this->userRepository)->email()->noWhitespace()->notEmpty(),
            'role' => v::roleAvailable($this->roleRepository)->notEmpty()->noWhitespace()->intVal(),
            'active' => v::boolVal(),
        ]);

        if ($validation->failed()) {
            return RouteHelpers::redirect($request, $response, 'users-management.get.createInvitation');
        }

        $this->invitationUserService->create($request->getParsedBody());

        return RouteHelpers::redirect($request, $response, 'users.list');
    }
}
