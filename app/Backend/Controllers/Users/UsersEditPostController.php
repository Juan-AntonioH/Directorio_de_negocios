<?php

namespace App\Backend\Controllers\Users;

use App\Backend\Repositories\RoleRepository;
use App\Backend\Repositories\UserRepository;
use App\Backend\Services\UserService;
use App\Shared\Controllers\PostController;
use App\Shared\Helpers\RouteHelpers;
use App\Shared\Services\UploadService;
use App\Shared\Validation\Validator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator as v;
use Slim\Flash\Messages as Flash;

final class UsersEditPostController extends PostController
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash)
    {
        parent::__construct($container, $validator, $flash);
        $this->userService = $this->container->get(UserService::class);
        $this->roleRepository = $this->container->get(RoleRepository::class);
        $this->userRepository = $this->container->get(UserRepository::class);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $validation = $this->validator->validate($request, [
            'username' => v::notEmpty(),
            'email' => v::email()->noWhitespace()->notEmpty(),
            'role' => v::roleAvailable($this->roleRepository)->intVal(),
            'active' => v::boolVal(),
        ]);

        if ($validation->failed()) {
            return RouteHelpers::redirect($request, $response, 'users-management.post.edit', ['id_user' => $args['id_user']]);
        }

        $filename = null;
        $photo = $request->getUploadedFiles()['profile-photo'];
        if (!is_null($photo) && $photo->getError() === UPLOAD_ERR_OK) {
            $uploadService = new UploadService($this->container->get('settings')['uploads']['profile_directory'], $photo);
            $filename = $uploadService->upload();
        }

        $this->userService->edit(
            $this->userRepository->find($args['id_user']),
            [
                'name' => $request->getParsedBody()['username'],
                'email' => $request->getParsedBody()['email'],
                'id_rol' => intval($request->getParsedBody()['role']),
                'active' => intval($request->getParsedBody()['active']),
                'photo' => $filename,
            ]
        );

        return RouteHelpers::redirect($request, $response, 'users-management.post.edit', ['id_user' => $args['id_user']]);
    }
}
