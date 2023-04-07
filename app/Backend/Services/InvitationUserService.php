<?php

namespace App\Backend\Services;

use App\Backend\Models\User;
use App\Backend\Models\UserInvitation;
use App\Backend\Repositories\UserInvitationRepository;
use App\Backend\Repositories\UserRepository;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages as Flash;

final class InvitationUserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Flash
     */
    private $flash;
    /**
     * @var UserInvitationRepository
     */
    private $userInvitationRepository;

    private $signatureKey = 'd64ea49add55531adf46d22032db1a3b';

    public function __construct(UserRepository $userRepository, UserInvitationRepository $userInvitationRepository, ContainerInterface $container, Flash $flash)
    {
        $this->userRepository = $userRepository;
        $this->container = $container;
        $this->flash = $flash;
        $this->userInvitationRepository = $userInvitationRepository;
    }

    public function edit(UserInvitation $userInvitation, array $fields)
    {
        foreach ($fields as $field => $value) {
            $userInvitation->{$field} = $value;
        }

        $this->userInvitationRepository->update($userInvitation);
        $this->flash->addMessage('success', 'Se ha modificado la invitación correctamente');
    }

    public function create(array $fields)
    {
        $userInvitation = new UserInvitation();

        $userInvitation->name = $fields['username'];
        $userInvitation->email = $fields['email'];
        $userInvitation->id_role = $fields['role'];
        $userInvitation->active = $fields['active'];
        $userInvitation->token = $this->generateToken($fields['email']);

        $this->userInvitationRepository->save($userInvitation);

        unset($_SESSION['old']);

        $this->flash->addMessage('success', 'Se ha enviado la invitación correctamente');
    }

    public function createUserFromInvitation(UserInvitation $userInvitation, $password)
    {
        $user = new User($this->container);
        $user->name = $userInvitation->name;
        $user->email = $userInvitation->email;
        $user->id_rol = $userInvitation->id_role;
        $user->active = $userInvitation->active;
        $user->setPassword($password);

        return $this->userRepository->save($user);
    }

    public function generateToken($email)
    {
        return hash('sha512', "{$email}::{$this->signatureKey}");
    }
}
