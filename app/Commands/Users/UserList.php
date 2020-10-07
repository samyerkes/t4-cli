<?php

namespace App\Commands\Users;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class UserList extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:list
                            {--fields=id,username,firstName,lastName,emailAddress : Instead of returning the whole user, returns the value of a specified field.}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter.}
                            {--format=table}';

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
        $url = '/user';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $filter = $this->filter($this->option('filter'));
        
        $format = $this->option('format');

        $data = $this->getFilteredContent($data, $filter);

        $data = $this->getFieldsOfContent($data, $fields);

        $this->printWithFormatter($data, $format);
        
    }

}
