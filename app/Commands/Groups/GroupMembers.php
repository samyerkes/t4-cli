<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class GroupMembers extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:members {group}
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
        $group = $this->argument('group');
        
        $group = $this->getDetails('group', $group)->first();

        $url = __('api.group.show', ['group' => $group['id']]);

        $data = $this->sendRequest($url);

        $data = collect($data['members']);

        $filter = $this->filter($this->option('filter'));
        
        $data = $this->getFilteredContent($data, $filter);
        
        $fields = $this->fields($this->option('fields'));
        
        $data = $this->getFieldsOfContent($data, $fields);

        $sortField = $this->option('sort');

        $sortOrder = $this->option('order');

        $data = $this->sortContent($data, $sortField, $sortOrder);
        
        $format = $this->option('format');

        $this->printWithFormatter($data, $format);

    }

}
