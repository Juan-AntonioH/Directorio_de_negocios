<?php

namespace App\Backend\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Popularity extends BaseModel implements ModelInterface
{
    public $id;
    public $id_user;
    public $id_company;
    public $vote;


    public function getUpdateValues(): array
    {
        return ['id_user', 'id_company', 'vote'];
    }

    public function getCreateValues(): array
    {
        return ['id_user', 'id_company', 'vote'];
    }
    
}