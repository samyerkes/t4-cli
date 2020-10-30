<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserGet extends Command
{
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'user:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of users';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'user',
        'users',
        'user:list',
        'users:get',
        'users:list'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'id',
        'username',
        'role'
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "firstName",
        "lastName",
        "emailAddress",
        "defaultLang",
        "enabled",
        "authLevel",
        "deleted"
    ];

    public function handle()
    {
        $data = $this->getDetails('user', $this->argument('details'));

        $factory = new UserFactory();
        $users = $factory->generate($data);

        $this->print($users);
    }

}
