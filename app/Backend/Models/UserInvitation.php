<?php

namespace App\Backend\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class UserInvitation extends BaseModel implements ModelInterface
{
    public $id;
    public $name;
    public $email;
    public $id_user;
    public $id_role;
    public $token;
    public $active;

    public function getUpdateValues(): array
    {
        return ['name', 'email', 'id_role', 'id_user', 'active'];
    }

    public function getCreateValues(): array
    {
        return ['name', 'email', 'id_role', 'active', 'token'];
    }
}
