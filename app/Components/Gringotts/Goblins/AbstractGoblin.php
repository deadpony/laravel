<?php

namespace App\Components\Gringotts\Goblins;

use App\Components\Gringotts\Goblins\Contracts\GoblinContract;

abstract class AbstractGoblin implements GoblinContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type) : void
    {
        $this->type = $type;
    }
}