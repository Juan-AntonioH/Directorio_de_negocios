<?php

namespace App\Backend\Repositories;

use App\Backend\Models\User;
use App\Shared\Helpers\DB;
use App\Shared\Repositories\BaseRepository;
use Psr\Container\ContainerInterface;

final class UserRepository extends BaseRepository
{
    public $tableName = 'users';
    public $class = User::class;
    public $dependencies = [];

    public function __construct(DB $db, ContainerInterface $container)
    {
        $this->dependencies[] = $container;
        parent::__construct($db, $container);
    }

    public function findAll()
    {
        $s = $this->db->prepare('SELECT u.*, rol.name_show as rol_name, rol.name as rol
                                          FROM ' . $this->tableName . ' as u 
                                          INNER JOIN roles as rol ON u.id_rol = rol.id');
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetchAll();
    }

    public function find($id)
    {
        $s = $this->db->prepare('SELECT u.*, rol.name_show as rol_name, rol.name as rol
                                          FROM ' . $this->tableName . ' as u 
                                          INNER JOIN roles as rol ON u.id_rol = rol.id
                                          WHERE u.id = :idUser');
        $s->bindParam(':idUser', $id, \PDO::PARAM_INT);
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }

    public function findByEmail($email)
    {
        $s = $this->db->prepare('SELECT u.*, rol.name_show as rol_name, rol.name as rol FROM ' . $this->tableName . ' as u INNER JOIN roles as rol ON u.id_rol = rol.id WHERE u.email = :email');
        $s->bindParam(':email', $email, \PDO::PARAM_STR);
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }

    public function saveLastLogin(User $user)
    {
        $s = $this->db->prepare('
            INSERT INTO login_log 
                (id_user) 
            VALUES 
                (:id)
        ');
        $s->bindParam(':id', $user->id);

        return $s->execute();
    }

    public function getLoginHistory(User $user)
    {
        $s = $this->db->prepare('SELECT *
                                          FROM login_log
                                          WHERE id_user = :id
                                          ORDER BY timestamp DESC
                                          LIMIT 5');
        $s->bindParam(':id', $user->id);
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_ASSOC);

        return $s->fetchAll();
    }
}
