<?php

namespace App\Backend\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class EqualsPasswordsException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Las contraseñas no son iguales.',
        ],
    ];
}
