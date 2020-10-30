<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserGet extends Command
{
    protected $name = 'user:get';

    protected $description = 'Get a list of users';

    protected $aliases = [
        'user',
        'users',
        'user:list',
        'users:get',
        'users:list'
    ];

    protected $fields = [
        'id',
        'username'
    ];

    public function handle()
    {
        $data = $this->getDetails('user', $this->argument('details'));

        $factory = new UserFactory();
        $users = $factory->generate($data);

        $this->print($users);
    }

}
