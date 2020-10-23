<?php

namespace App\Commands\Users;

use App\Command;

class UserGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:get {users?*}
                            {--fields=id,username,emailAddress,firstName,lastName,authLevel : Instead of returning the whole user, returns the value of a specified field. (optional)}
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
        $users = $this->argument('users');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $labels = $this->option('labels');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));

        // Get the details of users passed into the command
        $data = $this->getDetails('user', $users);

        if (count($data)) {
            
            // If the command has the label flag then just do an early return. 
            if ($labels) return $this->printLabels($data);
        
            $data = $this->getFilteredContent($data, $filter);
            
            $data = $this->getFieldsOfContent($data, $fields);
    
            $data = $this->sortContent($data, $sortField, $sortOrder);
    
            $this->printWithFormatter($data, $format);
        }

    }

}
