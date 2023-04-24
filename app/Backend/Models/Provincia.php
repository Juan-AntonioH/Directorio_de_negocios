<?php

namespace App\Backend\Models;

use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;

final class Provincia extends BaseModel implements ModelInterface
{
    public $id;
    public $name;
    
}