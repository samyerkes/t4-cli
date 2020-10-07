<?php

namespace App\Traits;

Trait Customizable
{
    public function fields($input) 
    {
        return explode(',', $input);
    }

    public function filter($input) 
    {
        return explode(':', $input);
    }
}
