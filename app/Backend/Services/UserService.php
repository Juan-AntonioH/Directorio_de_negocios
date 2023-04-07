<?php

namespace App\Backend\Services;

use App\Backend\Models\User;
use App\Backend\Repositories\UserRepository;
use Psr\Container\ContainerInterface;
use Slim\Flash\Messages as Flash;

final class UserService
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

    public function __construct(UserRepository $userRepository, ContainerInterface $container, Flash $flash)
    {
        $this->userRepository = $userRepository;
        $this->container = $container;
        $this->flash = $flash;
    }

    public function edit(User $user, array $fields)
    {
        foreach ($fields as $field => $value) {
            $user->{$field} = $value;
        }

        $this->userRepository->update($user);
        $this->flash->addMessage('success', 'Datos modificados correctamente');
    }

    public function changePassword(User $user, $password)
    {
        $user->setPassword($password);

        $this->userRepository->update($user);

        $this->flash->addMessage('success', 'Contraseña cambiada correctamente');

        return true;
    }
}
