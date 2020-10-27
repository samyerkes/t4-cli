<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:get {details?*}
                            {--fields=id,username,emailAddress,firstName,lastName,role : Instead of returning the whole user, returns the value of a specified field. (optional)}
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
    protected $description = 'Gets details about one or more specific users.';

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
        $data = $this->getDetails('user', $this->details);

        $factory = new UserFactory();
        $users = $factory->generate($data);

        if ($users->count()) {
            
            // If the command has the label flag then just do an early return. 
            if ($this->labels) return $this->printLabels($users);
        
            $users = $this->getFilteredContent($users, $this->filters);
            
            $users = $this->getFieldsOfContent($users, $this->fields);
    
            $users = $this->sortContent($users, $this->sort, $this->order);
    
            $this->printWithFormatter($users, $this->format);
        }

    }

}
