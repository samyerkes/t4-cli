<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4;

class GroupDelete extends Command
{
    use T4;
    
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
        $data = $this->sendRequest('delete', $url);

        $this->info("Success: Deleted group {$name}");

    }

}
