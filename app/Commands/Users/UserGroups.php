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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Arguments and options
        $this->getOptions();

        $users = $this->getDetails('user', $this->details);

        $data = $users->flatMap(function($user) {
            return $this->getDetails('usergroup', $user)->toArray();
        });

        // Remove duplicate groups due to some users being the same groups as others.
        $data = $data->unique();

        if (count($data)) {
            
            // If the command has the label flag then just do an early return. 
            if ($this->labels) return $this->printLabels($data);
        
            $data = $this->getFilteredContent($data, $this->filters);
            
            $data = $this->getFieldsOfContent($data, $this->fields);
    
            $data = $this->sortContent($data, $this->sort, $this->order);
    
            $this->printWithFormatter($data, $this->format);
        }

    }

}
