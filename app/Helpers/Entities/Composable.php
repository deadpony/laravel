<?php

namespace App\Helpers\Entities;

abstract class Composable implements \App\Helpers\Entities\Contracts\Composable
{
    public function compose(array $input): void
    {
         collect($input)->each(function($value, $key) {
             $method = "set".ucfirst(camel_case($key));
             if (method_exists($this, $method)) {
                 $this->{$method}($value);
             }
         });
    }
}