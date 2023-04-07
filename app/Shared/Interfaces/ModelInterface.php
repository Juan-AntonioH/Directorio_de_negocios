<?php

namespace App\Shared\Interfaces;

interface ModelInterface
{
    public function getUpdateValues(): array;

    public function getCreateValues(): array;
}
