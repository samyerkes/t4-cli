<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class GroupGet extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:get {groups?*}
                            {--fields=id,name : Instead of returning the whole group, returns the value of a specified field.}
                            {--filter= : Instead of returning all groups, returns the groups who only match a specific filter.}
                            {--format=table}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get details about a group';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Arguments and options
        $groups = $this->argument('groups');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));

        // Get the details of users passed into the command
        $data = $this->getDetails('group', $groups);
        
        if (count($data)) {
        
            $data = $this->getFilteredContent($data, $filter);
            
            $data = $this->getFieldsOfContent($data, $fields);
    
            $data = $this->sortContent($data, $sortField, $sortOrder);
    
            $this->printWithFormatter($data, $format);
        }

    }

}
