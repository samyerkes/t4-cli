<?php

namespace App\Factories;

use App\Command;
use App\Models\ContentType;
use App\Traits\T4able;

class ContentTypeFactory {

    use T4able;

    public function generate($data) 
    {
        $contenttypes = collect([]);
        foreach ($data as $contenttype) 
        {
            $contenttypeDTO = new ContentType;
            $contenttypeDTO = $contenttypeDTO->fill($contenttype);
            $contenttypes->push($contenttypeDTO);
        }
        return $contenttypes;
    }
}