<?php

namespace App\Backend\Repositories;

use App\Backend\Models\Company;
use App\Shared\Repositories\BaseRepository;

final class CompanyRepository extends BaseRepository
{
    public $tableName = 'company';
    public $class = Company::class;
}