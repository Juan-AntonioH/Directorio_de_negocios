<?php

namespace App\Backend\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class RoleAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'El rol no existe.',
        ],
    ];
}
