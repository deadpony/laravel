<?php

namespace App\Components\Gringotts\Goblins;

use App\Components\Gringotts\Goblins\Contracts\Abilities\TermableContract;
use App\Components\Gringotts\Goblins\Contracts\GoblinContract;

abstract class AbstractGoblin implements GoblinContract, TermableContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $term = [];

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

    /**
     * @return array
     */
    protected function getTerm(): array
    {
        return $this->term;
    }

    /**
     * @param array $term
     */
    protected function setTerm(array $term)
    {
        $this->term = $term;
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            $this->test1();
            return call_user_func_array(array($this, $method), $arguments);
        }
    }
}