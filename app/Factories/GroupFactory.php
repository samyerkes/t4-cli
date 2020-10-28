<?php

namespace App\Factories;

use App\Models\Group;
use App\Traits\T4able;

class GroupFactory {

    use T4able;

    public function generate($data) 
    {
        $groups = collect([]);
        foreach ($data as $group) 
        {
            $groupDTO = new Group;
            $groupDTO = $groupDTO->fill($group);
            $groups->push($groupDTO);
        }
        return $groups;
    }
}