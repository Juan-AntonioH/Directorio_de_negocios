<?php

namespace App\Backend\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class EmailAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Ya existe un usuario con este email.',
        ],
    ];
}
