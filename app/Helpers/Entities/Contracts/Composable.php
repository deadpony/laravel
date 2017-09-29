<?php

namespace App\Helpers\Entities\Contracts;

interface Composable
{
    /**
     * @param array $input
     * @return void
     */
    public function compose(array $input) : void;
}