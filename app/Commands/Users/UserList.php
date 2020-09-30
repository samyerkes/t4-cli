<?php

namespace App\Commands\Users;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4;

class UserList extends Command
{
    use T4;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:list
                            {--fields=username : Instead of returning the whole user, returns the value of a specified field. (optional)}';

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
        $fields = explode(',', $fields);

        $url = '/user';
        $data = $this->getContent($url);

        $data->each(function ($user) use ($fields) {
            $string = '';
            foreach ($fields as $key => $field) {
                $space = ($key !== 0) ? ' ' : '';
                $string .= $space . $user[$field];
            }
            $this->line($string);
        });

    }

}
