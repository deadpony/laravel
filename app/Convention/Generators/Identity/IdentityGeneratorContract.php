<?php

namespace App\Convention\Generators\Identity;

use App\Convention\ValueObjects\Identity\Identity;

interface IdentityGeneratorContract
{
    /**
     * @return Identity
     */
    public static function next(): Identity;
}