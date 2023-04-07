<?php

namespace App\Shared\Models;

class BaseModel
{
    public const DB_IDENTIFIER = 'id';

    public function getUpdateValues(): array
    {
        return [];
    }

    public function getCreateValues(): array
    {
        return [];
    }
}
