<?php
namespace App\Enums;

interface Enum
{
    public function equal(mixed $value): bool;
}
