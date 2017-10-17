<?php

namespace App\Convention\DTO\Contracts;

interface JsonDTO
{
    /**
     * @return array
     */
    public function __toArray(): array;

    /**
     * @return string
     */
    public function __toJson(): string;
}