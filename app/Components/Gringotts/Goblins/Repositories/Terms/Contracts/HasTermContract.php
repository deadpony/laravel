<?php

namespace App\Components\Gringotts\Goblins\Repositories\Terms\Contracts;

use App\Components\Gringotts\Goblins\Entities\Contracts\TermContract;

interface HasTermContract
{

    /**
     * @return TermContract
     */
    public function term() : TermContract;

}
