<?php

namespace App\Commands\Groups;

use App\Command;
use App\Factories\UserFactory;

class GroupMembers extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'group:members';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Returns the members of a group';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'group:member',
        'groups:members',
        'members'
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        $groups = $this->getDetails('group', $this->argument('details'));
      
        $data = $groups->flatMap(function($group) {
            return $this->getDetails('groupmember', $group)->toArray();
        });

        $factory = new UserFactory();
        $users = $factory->generate($data);
        
        $this->print($users);

    }

}
