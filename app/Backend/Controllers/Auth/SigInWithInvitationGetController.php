<?php

namespace App\Backend\Controllers\Auth;

use App\Backend\Repositories\UserInvitationRepository;
use App\Shared\Controllers\FrontController;
use App\Shared\Helpers\RouteHelpers;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;

final class SigInWithInvitationGetController extends FrontController
{
    /**
     * @var UserInvitationRepository
     */
    private $userInvitationRepository;

    public function __construct(ContainerInterface $container, Twig $twig, Flash $flash, UserInvitationRepository $userInvitationRepository)
    {
        parent::__construct($container, $twig, $flash);
        $this->userInvitationRepository = $userInvitationRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $invitation = $this->userInvitationRepository->findWhere('WHERE token = :token', [
            ':token' => [
                'value' => $args['token'],
                'type' => \PDO::PARAM_STR,
            ],
        ]);

        if (!$invitation || !is_null($invitation->id_user)) {
            return RouteHelpers::redirect($request, $response, 'auth.get.login');
        }

        // Render index view
        return $this->twig->render($response, '@backend/auth/sigin_with_invitation.twig', [
            'invitation' => $invitation,
        ]);
    }
}
