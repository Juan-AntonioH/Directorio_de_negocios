<?php

namespace App\Backend\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Role extends BaseModel implements ModelInterface
{
    public $id;
    public $name_show;
    public $name;
}
