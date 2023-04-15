<?php

namespace App\Backend\Services;

use App\Backend\Models\User;
use Slim\Flash\Messages as Flash;
use Psr\Container\ContainerInterface;
use App\Backend\Repositories\UserRepository;

final class AuthService
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

    public function check()
    {
        return isset($_SESSION['user']) && $this->userRepository->find($_SESSION['user'])->active;
    }

    public function getUser()
    {
        return isset($_SESSION['user']) ? $this->userRepository->find($_SESSION['user']) : null;
    }

    public function signIn($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            $this->flash->addMessage('error', 'Usuario incorrecto');

            return false;
        }

        if (!$user->active) {
            $this->flash->addMessage('error', 'El usuario esta desactivado');

            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->id;
            $this->userRepository->saveLastLogin($user);

            return true;
        }

        $this->flash->addMessage('error', 'Contraseña incorrecta');

        return false;
    }

    public function register(array $fields)
    {
        $user = $this->userRepository->findByEmail($fields['email']);

        if ($user) {
            $this->flash->addMessage('error', 'Email ya registrado');

            return false;
        }
        

        $user = new User($this->container);

        foreach($fields as $key => $field){
            $user->$key = $field;
        }

        $user->setPassword($fields['password']);

        $this->userRepository->save($user);

        if($user = $this->userRepository->findByEmail($fields['email'])){
            $this->flash->addMessage('success', 'Registro completado con exito. Bienvenido '.$user->name);
            $_SESSION['user'] = $user->id;
            $this->userRepository->saveLastLogin($user);
            return true;
        }

        $this->flash->addMessage('error', 'Ocurrio un error inesperado');
        return false;

    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

    public function hasRole(array $rolsToCheck)
    {
        $user = $this->getUser();

        foreach ($rolsToCheck as $rolToCheck) {
            if ($user->rol == $rolToCheck) {
                return true;
            }
        }

        return false;
    }

    public function isRole($rolToCheck)
    {
        $user = $this->getUser();

        return $user->rol == $rolToCheck;
    }
}
