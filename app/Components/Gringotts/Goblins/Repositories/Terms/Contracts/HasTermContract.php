<?php

namespace App\Components\Gringotts\Goblins\Repositories\Terms\Contracts;

interface HasTermContract
{

    /**
     * @return TermContract
     */
    public function term() : TermContract;

}
