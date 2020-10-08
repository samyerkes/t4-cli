<?php

namespace App\Commands\Users;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class UserGet extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:get {user*}
                            {--fields=id,username,emailAddress,firstName,lastName : Instead of returning the whole user, returns the value of a specified field. (optional)}
                            {--format=table}
                            {--sort=id}
                            {--order=desc}';

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
        
        $url = '/user';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $format = $this->option('format');

        
        $data = $data->filter( function($d) use ($user) {
            return in_array($d['username'], $user);
        });
        
        $data = $data->toArray();

        $data = array_values($data);

        $data = $this->getFieldsOfContent($data, $fields);

        $sortField = $this->option('sort');

        $sortOrder = $this->option('order');

        $data = $this->sortContent($data, $sortField, $sortOrder);

        $this->printWithFormatter($data, $format);

    }

}
