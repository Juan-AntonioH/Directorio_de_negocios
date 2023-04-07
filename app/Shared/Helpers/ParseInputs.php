<?php

namespace App\Shared\Helpers;

class ParseInputs
{
    public static function parseSwitchButton($parsedBody, $switchName)
    {
        if (isset($parsedBody[$switchName]) && $parsedBody[$switchName] == 'on') {
            return true;
        }

        return false;
    }
}
