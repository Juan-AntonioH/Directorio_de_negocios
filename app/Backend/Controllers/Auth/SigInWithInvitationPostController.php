<?php

namespace App\Backend\Controllers\Auth;

use App\Backend\Repositories\UserInvitationRepository;
use App\Backend\Repositories\UserRepository;
use App\Backend\Services\AuthService;
use App\Backend\Services\InvitationUserService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;

final class SigInWithInvitationPostController extends PostController
{
    /**
     * @var UserInvitationRepository
     */
    private $userInvitationRepository;
    /**
     * @var InvitationUserService
     */
    private $invitationUserService;
    /**
     * @var AuthService
     */
    private $authService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash)
    {
        parent::__construct($container, $validator, $flash);
        $this->userInvitationRepository = $this->container->get(UserInvitationRepository::class);
        $this->invitationUserService = $this->container->get(InvitationUserService::class);
        $this->authService = $this->container->get(AuthService::class);
        $this->userRepository = $this->container->get(UserRepository::class);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $validation = $this->validator->validate($request, [
            'password' => v::noWhitespace()->notEmpty(),
            'confirmPassword' => v::noWhitespace()->notEmpty()->equalsPasswords($request->getParsedBody()['password']),
        ]);

        if ($validation->failed()) {
            return RouteHelpers::redirect($request, $response, 'auth.get.sigin.withInvitation', ['token' => $args['token']]);
        }

        $invitation = $this->userInvitationRepository->findWhere('WHERE token = :token', [
            ':token' => [
                'value' => $args['token'],
                'type' => \PDO::PARAM_STR,
            ],
        ]);

        if (!$invitation) {
            return RouteHelpers::redirect($request, $response, 'auth.get.login');
        }

        $createUser = $this->invitationUserService->createUserFromInvitation($invitation, $request->getParsedBody()['password']);

        if (!$createUser) {
            $this->flash->addMessage('error', 'Error al crear el usuario');

            return RouteHelpers::redirect($request, $response, 'auth.get.sigin.withInvitation', ['token' => $args['token']]);
        }

        $user = $this->userRepository->findByEmail($invitation->email);

        $invitation->id_user = $user->id;

        $this->userInvitationRepository->save($invitation);

        $this->authService->signIn(
            $invitation->email,
            $request->getParsedBody()['password']
        );

        return RouteHelpers::redirect($request, $response, 'dashboard');
    }
}
