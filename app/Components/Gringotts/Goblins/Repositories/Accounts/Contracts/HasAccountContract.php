<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts;

interface HasAccountContract
{

    /**
     * @return AccountContract
     */
    public function account() : AccountContract;

}
