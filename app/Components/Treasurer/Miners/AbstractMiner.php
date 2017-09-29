<?php

namespace App\Components\Treasurer\Miners;

use App\Components\Treasurer\Miners\Contracts\MinerContract;

abstract class AbstractMiner implements MinerContract
{

    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

}