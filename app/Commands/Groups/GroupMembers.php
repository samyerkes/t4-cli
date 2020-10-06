<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4able;

class GroupMembers extends Command
{
    use T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:members {name}
                            {--fields=username : Instead of returning the whole group, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all groups, returns the groups who only match a specific filter. (optional)}';

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
        $name = $this->argument('name');

        $fields = $this->option('fields');
        $filter = $this->option('filter');
        $fields = explode(',', $fields);
        $filter = explode(':', $filter);

        $groupId = $this->findGroupID($name);
        $url = "/group/{$groupId}";
        $data = $this->sendRequest($url);

        $data = $this->getFilteredContent($data, $filter);

        $members = collect($data['members']);

        $members->each(function ($group) use ($fields) {
            $output = $this->formatOutput($group, $fields);
            $this->line($output);
        });

    }

}
