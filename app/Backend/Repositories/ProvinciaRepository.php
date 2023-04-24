<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Provincia;
use App\Shared\Repositories\BaseRepository;

final class ProvinciaRepository extends BaseRepository
{
    public $tableName = 'provincias';
    public $class = Provincia::class;
}