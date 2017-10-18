<?php

namespace App\Convention\DTO\Contracts;

interface JsonDTO extends \JsonSerializable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array;
}