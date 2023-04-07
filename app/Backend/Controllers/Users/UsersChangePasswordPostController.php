<?php

namespace App\Controllers\Users;

use App\Controllers\Shared\PostController;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Validation\Validator;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

final class UsersChangePasswordPostController extends PostController
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Router
     */
    private $router;

    public function __construct(ContainerInterface $container, Validator $validator, Router $router, Flash $flash, UserService $userService, UserRepository $userRepository)
    {
        parent::__construct($container, $validator, $flash);
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, $id_user)
    {
        $validation = $this->validator->validate($request, [
            'password' => v::noWhitespace()->notEmpty(),
            'confirmPassword' => v::noWhitespace()->notEmpty()->equalsPasswords($request->getParam('password')),
        ]);

        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('users-management.get.edit', ['id_user' => $id_user]));
        }

        $this->userService->changePassword($this->userRepository->find($id_user), $request->getParam('password'));

        return $response->withRedirect($this->router->pathFor('users-management.get.edit', ['id_user' => $id_user]));
    }
}
