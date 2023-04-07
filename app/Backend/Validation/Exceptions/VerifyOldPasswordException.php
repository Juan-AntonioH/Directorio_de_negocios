<?php

namespace App\Backend\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class VerifyOldPasswordException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Contraseña incorrecta.',
        ],
    ];
}
