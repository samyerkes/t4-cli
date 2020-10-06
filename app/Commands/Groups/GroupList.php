<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4able;

class GroupList extends Command
{
    use T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:list {user?}
                            {--fields=name : Instead of returning the whole group, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all groups, returns the groups who only match a specific filter. (optional)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List groups';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');
        $fields = $this->option('fields');
        $filter = $this->option('filter');
        $fields = explode(',', $fields);
        $filter = explode(':', $filter);

        if ($user) {
            $user = $this->findUserID($user);
        }

        $url = $user ? "/group/user/{$user}" : '/group';
        $data = $this->sendRequest($url);

        $data = $this->getFilteredContent($data, $filter);

        $data->each(function ($group) use ($fields) {
            $output = $this->formatOutput($group, $fields);
            $this->line($output);
        });

    }

}
