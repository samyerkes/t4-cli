<?php

namespace App\Factories;

use App\Command;
use App\Models\Navigation;
use App\Traits\T4able;

class NavigationFactory {

    use T4able;

    public function generate($data) 
    {
        $navigations = collect([]);
        foreach ($data as $navigation) 
        {
            $navigationDTO = new Navigation;
            $navigationDTO = $navigationDTO->fill($navigation);
            $navigations->push($navigationDTO);
        }
        return $navigations;
    }
}