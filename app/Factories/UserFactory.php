<?php

namespace App\Factories;

use App\Command;
use App\Models\User;
use App\Traits\T4able;

class UserFactory {

    use T4able;

    public function generate($data) 
    {
        $users = collect([]);
        foreach ($data as $user) 
        {
            $userDTO = User::make($user);
            $users->push($userDTO);
        }
        return $users;
    }
}