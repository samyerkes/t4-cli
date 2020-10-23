<?php

namespace App\Commands\Groups;

use App\Command;

class GroupDelete extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:delete {group}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Deletes a groups';

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
        
        $data = $this->sendRequest($url, 'delete');

        $this->info("Success: Deleted group {$group['name']}");

    }

}
