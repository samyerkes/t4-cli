<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4able;

class GroupDelete extends Command
{
    use T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:delete {name}';

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
        $name = $this->argument('name');

        $groupId = $this->findGroupID($name);

        $url = "/group/{$groupId}";
        $data = $this->sendRequest($url, 'delete');

        $this->info("Success: Deleted group {$name}");

    }

}
