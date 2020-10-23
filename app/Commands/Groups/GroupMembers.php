<?php

namespace App\Commands\Groups;

use App\Command;

class GroupMembers extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:members {groups*}
                            {--fields=id,username : Instead of returning the whole group, returns the value of a specified field.}
                            {--filter= : Instead of returning all groups, returns the groups who only match a specific filter.}
                            {--format=table}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Returns the members of a group';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $groups = $this->argument('groups');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));
        
        $groups = $this->getDetails('group', $groups);

        $data = $groups->flatMap(function($group) {
            return $this->getDetails('groupmember', $group)->toArray();
        });

        if (count($data)) {
        
            $data = $this->getFilteredContent($data, $filter);
 
            $data = $this->getFieldsOfContent($data, $fields);
    
            $data = $this->sortContent($data, $sortField, $sortOrder);
    
            $this->printWithFormatter($data, $format);
        }

    }

}
