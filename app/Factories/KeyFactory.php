<?php

namespace App\Factories;

use App\Command;
use App\Models\Key;
use App\Traits\T4able;

class KeyFactory {

    use T4able;

    public function generate($data) 
    {
        $keys = collect([]);
        foreach ($data as $key) 
        {
            $keyDTO = new key;
            $keyDTO = $keyDTO->fill($key);
            $keys->push($keyDTO);
        }
        return $keys;
    }
}