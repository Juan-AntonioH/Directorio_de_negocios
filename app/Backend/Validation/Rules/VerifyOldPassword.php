<?php

namespace App\Backend\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

final class VerifyOldPassword extends AbstractRule
{
    /**
     * @var string
     */
    private $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function validate($input): bool
    {
        return password_verify($input, $this->password);
    }
}
