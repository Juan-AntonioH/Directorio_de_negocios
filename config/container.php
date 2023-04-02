<?php

use App\Backend\Services\AuthService;
use App\Shared\Helpers\DB;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;
use Slim\Flash\Messages as Flash;
use Slim\Views\Twig;
use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Twig\TwigFunction;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    DB::class => function (ContainerInterface $container) {
        $dbname = $container->get('settings')['db']['name'];
        $user = $container->get('settings')['db']['user'];
        $pass = $container->get('settings')['db']['pass'];
        $host = $container->get('settings')['db']['host'];
        $charset = $container->get('settings')['db']['charset'];
        $collate = $container->get('settings')['db']['collate'];

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset COLLATE $collate",
        ];

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';';

        return new DB($dsn, $user, $pass, $opt);
    },

    Flash::class => function () {
        $storage = [];

        return new Flash($storage);
    },

    Twig::class => function (ContainerInterface $c, AuthService $authService, Flash $flash) {
        $settings = $c->get('settings');

        // Obtenemos el nombre del namepspace de los templates
        foreach (glob('../templates/*', GLOB_ONLYDIR) as $dir) {
            $parts = explode('/', $dir);
            $templates[$parts[2]] = $dir;
        }

        $twig = Twig::create($templates);

        $twig->getEnvironment()->addGlobal('app_name', $settings['app']['name']);
        $twig->getEnvironment()->addGlobal('app_logo', $settings['app']['logo']);
        $twig->getEnvironment()->addGlobal('app_default_lang', $settings['app']['default_lang']);
        $twig->getEnvironment()->addGlobal('uploads_paths', $settings['twig']['uploads']);

        $twig->getEnvironment()->addGlobal('auth', [
            'user' => $authService->getUser(),
            'check' => $authService->check(),
        ]);

        $hasRoles = new TwigFunction('hasRoles', function (array $rolesToCheck) use ($authService) {
            return $authService->hasRole($rolesToCheck);
        });

        $twig->getEnvironment()->addFunction($hasRoles);

        $isRole = new TwigFunction('isRole', function ($rolToCheck) use ($authService) {
            return $authService->isRole($rolToCheck);
        });

        $twig->getEnvironment()->addFunction($isRole);

        $twig->getEnvironment()->addGlobal('flash', $flash);

        $profilePath = new TwigFunction('profile_path', function () use ($c, $settings) {
            return $c->get('request')->getUri()->getBaseUrl() . $settings['twig']['uploads']['profile_path'];
        });

        $twig->getEnvironment()->addFunction($profilePath);

        $absoluteUrl = new TwigFunction('absolute_url', function () use ($c, $settings) {
            return $_SERVER['HTTP_HOST'];
        });

        $twig->getEnvironment()->addFunction($absoluteUrl);

        return $twig;
    },

    Mailer::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['smtp'];

        $transport = new EsmtpTransport(
            $settings['host'],
            $settings['port'],
        // $settings['encryption']
        );

        $transport->setUsername($settings['username']);
        $transport->setPassword($settings['password']);

        return new Mailer($transport);
    },

    'csrf' => function (ContainerInterface $c) {
        $app = $c->get(App::class);
        $responseFactory = $app->getResponseFactory();

        return new Guard($responseFactory);
    },

    BodyRenderer::class => function(ContainerInterface $c){
        $twigEnv = $c->get(Twig::class)->getEnvironment();

        return new BodyRenderer($twigEnv);
    }
];
