<?php

namespace App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts;

use App\Components\Gringotts\Goblins\Entities\Contracts\AccountContract;

interface HasAccountContract
{

    /**
     * @return AccountContract
     */
    public function account() : AccountContract;

}
