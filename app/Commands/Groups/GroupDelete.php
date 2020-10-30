<?php

namespace App\Commands\Groups;

use App\Command;
use App\Factories\GroupFactory;

class GroupDelete extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'group:delete';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Deletes a groups';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'groups:delete'
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
        
        foreach ($groups as $group) 
        {   
            $url = __('api.group.show', ['group' => $group['id']]);
        
            $data = $this->sendRequest($url, 'delete');
    
            $this->info(__('actions.delete', ['model' => 'Group', 'detail' => $group['name']]));
        }

    }

}
