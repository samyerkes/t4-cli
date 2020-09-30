<?php

namespace App\Commands\Users;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4;

class UserGet extends Command
{
    use T4;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:get {user}
                            {--fields=id,username,emailAddress,firstName,lastName : Instead of returning the whole user, returns the value of a specified field. (optional)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets details about a user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');
        $fields = $this->option('fields');
        $fields = explode(',', $fields);

        $url = '/user';
        $data = $this->sendRequest($url);

        $user = $data->firstWhere('username', $user);

        $output = $this->formatOutput($user, $fields);
        $this->line($output);

    }

}
