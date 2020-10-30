<?php

namespace App\Commands\Groups;

use App\Command;
use App\Factories\GroupFactory;

class GroupGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'group:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of groups';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'group',
        'groups',
        'group:list',
        'groups:get',
        'groups:list'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'id' ,
        'name',
        'membersCount' 
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "defaultPreviewChannel",
        "description",
        "emailAddress"
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->getDetails('group', $this->argument('details'));

        $factory = new GroupFactory();
        $groups = $factory->generate($data);
        
        $this->print($groups);
    }

}
