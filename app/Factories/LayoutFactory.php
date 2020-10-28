<?php

namespace App\Factories;

use App\Command;
use App\Models\Layout;
use App\Traits\T4able;

class LayoutFactory {

    use T4able;

    public function generate($data) 
    {
        $layouts = collect([]);
        foreach ($data as $layout) 
        {
            $layoutDTO = new Layout;
            $layoutDTO = $layoutDTO->fill($layout);
            $layouts->push($layoutDTO);
        }
        return $layouts;
    }
}