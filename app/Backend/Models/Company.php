<?php

namespace App\Backend\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Company extends BaseModel implements ModelInterface
{
    public $id;
    public $name;
    public $direction;
    public $phone;
    public $email;
    public $url;
    public $description;
    public $active = 1;
    public $provincia;
    public $id_creator;
    public $created_at;


    public function getUpdateValues(): array
    {
        return ['name', 'direction', 'phone', 'email', 'url', 'description', 'active', 'provincia','deleted'];
    }

    public function getCreateValues(): array
    {
        return ['name', 'direction', 'phone', 'email', 'url', 'description', 'active', 'provincia', 'id_creator'];
    }
}
