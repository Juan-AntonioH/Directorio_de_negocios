<?php

namespace App\Backend\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

final class EqualsPasswords extends AbstractRule
{
    /**
     * @var string
     */
    private $valueToCompare;

    public function __construct($valueToCompare)
    {
        $this->valueToCompare = $valueToCompare;
    }

    public function validate($input): bool
    {
        return $this->valueToCompare == $input;
    }
}
