<?php

namespace App\Commands\Users;

use App\Command;

class UserGroups extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:groups {details?*}
                            {--fields=id,name : Instead of returning the whole user, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets group details for one or more users.';

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
