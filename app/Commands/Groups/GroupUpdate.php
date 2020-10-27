<?php

namespace App\Commands\Groups;

use App\Command;
use App\Factories\GroupFactory;

class GroupUpdate extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:update {details?*}
                            {--name=}
                            {--description=}
                            {--emailAddress=}
                            {--defaultPreviewChannel=}
                            {--enabled=}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Updates details about a group';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Arguments and options
        $this->getOptions();

        // Get the details of users passed into the command
        $data = $this->getDetails('group', $this->details);

        $factory = new GroupFactory();
        $groups = $factory->generate($data);
        
        foreach ($groups as $group) 
        {   
            $options = array_filter($this->option()); // gets rid of null values
            $group->fill($options);
            
            // Send the Update request
            $request = $this->sendRequest(__('api.group.show', ['group' => $group->id]), 'put', $group->toArray());
            
            $this->info(__('actions.update', ['model' => 'Group', 'detail' => $group->name]));
        }

    }

}
