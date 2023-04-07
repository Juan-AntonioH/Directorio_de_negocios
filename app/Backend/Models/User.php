<?php

namespace App\Backend\Models;

use App\Backend\Repositories\UserRepository;
use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;
use Psr\Container\ContainerInterface;
use Slim\App;

final class User extends BaseModel implements ModelInterface
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $active;
    public $id_rol;
    public $rol_name;
    public $rol;
    public $photo;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->photo = $this->getPhoto();
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getLoginHistory()
    {
        return $this->container->get(UserRepository::class)->getLoginHistory($this);
    }

    private function getPhoto()
    {
        if (empty($this->photo)) {
            return 'https://ui-avatars.com/api/?name=' . $this->name . '&color=7F9CF5&background=EBF4FF&size=64';
        }

        $routeParser = $this->container->get(App::class)->getRouteCollector()->getRouteParser();

        return $routeParser->urlFor('get.private.image', ['type' => 'profile', 'file' => $this->photo]);
    }

    public function getUpdateValues(): array
    {
        return ['name', 'email', 'password', 'active', 'id_rol', 'photo'];
    }

    public function getCreateValues(): array
    {
        return ['name', 'email', 'password', 'active', 'id_rol'];
    }
}
