<?php

namespace App\Factories;

use App\Models\Section;
use App\Traits\T4able;

class SectionFactory {

    use T4able;

    public function generate($data) 
    {
        $sections = collect([]);
        foreach ($data as $section) 
        {
            $sectionDTO = new Section;
            $sectionDTO = $sectionDTO->fill($section);
            $sections->push($sectionDTO);
        }
        return $sections;
    }
}