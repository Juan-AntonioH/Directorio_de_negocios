<?php

namespace App\Backend\Controllers;

use App\Shared\Controllers\FrontController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PrivateImageController extends FrontController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $image = null;
        switch ($args['type']) {
            case 'profile':
                $image = file_exists($this->container->get('settings')['uploads']['profile_directory'] . $args['file']) ? $this->container->get('settings')['uploads']['profile_directory'] . $args['file'] : null;
                break;
            default:
                throw new \Exception('Unexpected value');
        }

        if (is_null($image)) {
            throw new \Exception('Unexpected value');
        }

        $image = file_get_contents($image);
        $response->getBody()->write($image);

        return $response->withHeader('Content-Type', 'image/png');
    }
}
