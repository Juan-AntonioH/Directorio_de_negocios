<?php

namespace App\Backend\Controllers;

use App\Shared\Controllers\FrontController;
use App\Shared\Streams\NonBufferedBody;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ExecuteMigrationsController extends FrontController
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        // Si el token no es correcto
        if ($args['token'] != $this->container->get('settings')['migrations']['token']) {
            $data = ['error' => true, 'message' => 'Token incorrecto'];
            $payload = json_encode($data);

            $response->getBody()->write($payload);

            return $response
                ->withHeader('Content-Type', 'application/json');
        }

        if (!is_file(__DIR__ . '/../../../migrations/lanzar_migraciones.php')) {
            $data = ['error' => true, 'message' => 'Fichero de migración no encontrado'];
            $payload = json_encode($data);

            $response->getBody()->write($payload);

            return $response
                ->withHeader('Content-Type', 'application/json');
        }

        $firstFromRoute = false;

        if (isset($args['first']) && $args['first'] == 'first') {
            $firstFromRoute = true;
        }

        $response = new Response();
        $response->withBody(new NonBufferedBody());

        require __DIR__ . '/../../../migrations/lanzar_migraciones.php';

        return $response;
    }
}
