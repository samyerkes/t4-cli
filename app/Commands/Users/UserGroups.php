<?php

namespace App\Commands\Users;

use App\Command;

class UserGroups extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'user:groups';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets group details for one or more users';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'users:groups',
        'users:group',
        'user:group'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        "id",
        "name"
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "description",
        "emailAddress",
        "createDate",
        "enabled",
        "ldap",
        "defaultChannel",
        "deleted"
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = $this->getDetails('user', $this->argument('details'));

        $data = $users->flatMap(function($user) {
            return $this->getDetails('usergroup', $user)->toArray();
        });

        // Remove duplicate groups due to some users being the same groups as others.
        $data = $data->unique();

        $this->print($data);

    }

}
