<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class GroupList extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:list {user?}
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
    protected $description = 'List groups';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');

        if ($user) {
            $userId = $this->findUserID($user);
        }

        $url = $user ? "/group/user/{$userId}" : '/group';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $filter = $this->filter($this->option('filter'));
        
        $format = $this->option('format');

        $data = $this->getFilteredContent($data, $filter);

        $data = $this->getFieldsOfContent($data, $fields);

        $sortField = $this->option('sort');

        $sortOrder = $this->option('order');

        $data = $this->sortContent($data, $sortField, $sortOrder);

        $this->printWithFormatter($data, $format);

    }

}
