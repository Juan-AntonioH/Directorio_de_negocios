<?php

namespace App\Backend\Controllers\User;

use App\Backend\Services\AuthService;
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
use Slim\Views\Twig;

final class EditAccountPostController extends PostController
{
    private UserService $userService;
    private AuthService $authService;
    private Twig $twig;

    public function __construct(ContainerInterface $container, Validator $validator, Flash $flash, UserService $userService, AuthService $authService, Twig $twig)
    {
        parent::__construct($container, $validator, $flash);
        $this->userService = $userService;
        $this->authService = $authService;
        $this->twig = $twig;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $validation = $this->validator->validate($request, [
            'username' => v::notEmpty(),
            'email' => v::email()->noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed()) {
            return RouteHelpers::redirect($request, $response, 'user.edit.account');
        }

        $filename = null;
        $photo = $request->getUploadedFiles()['profile-photo'];

        if (!is_null($photo) && $photo->getError() === UPLOAD_ERR_OK) {
            $uploadService = new UploadService($this->container->get('settings')['uploads']['profile_directory'], $photo);
            $filename = $uploadService->upload();
        }

        $this->userService->edit(
            $this->authService->getUser(),
            [
                'name' => $request->getParsedBody()['username'],
                'email' => $request->getParsedBody()['email'],
                'photo' => $filename,
            ]
        );

        return RouteHelpers::redirect($request, $response, 'user.edit.account');
    }
}
