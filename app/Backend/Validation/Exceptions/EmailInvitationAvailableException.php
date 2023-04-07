<?php

namespace App\Backend\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class EmailInvitationAvailableException extends ValidationException
{
    protected $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Ya existe una invitación con este email.',
        ],
    ];
}
