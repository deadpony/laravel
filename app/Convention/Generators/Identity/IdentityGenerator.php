<?php

namespace App\Convention\Generators\Identity;

use App\Convention\ValueObjects\Identity\Identity;
use Ramsey\Uuid\Uuid;

class IdentityGenerator implements IdentityGeneratorContract
{
    /**
     * @return Identity
     */
    public static function next(): Identity
    {
        return new Identity(Uuid::uuid4()->toString());
    }
}