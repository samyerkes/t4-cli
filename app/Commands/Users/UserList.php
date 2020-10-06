<?php

namespace App\Commands\Users;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4able;

class UserList extends Command
{
    use T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:list
                            {--fields=username : Instead of returning the whole user, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter. (optional)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List users';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fields = $this->option('fields');
        $filter = $this->option('filter');
        $fields = explode(',', $fields);
        $filter = explode(':', $filter);

        $url = '/user';
        $data = $this->sendRequest($url);

        $data = $this->getFilteredContent($data, $filter);

        $data->each(function ($user) use ($fields) {
            $output = $this->formatOutput($user, $fields);
            $this->line($output);
        });

    }

}
