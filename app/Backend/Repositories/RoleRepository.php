<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Role;
use App\Shared\Repositories\BaseRepository;

final class RoleRepository extends BaseRepository
{
    public $tableName = 'roles';
    public $class = Role::class;
}
