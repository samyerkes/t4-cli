<?php

namespace App\Commands\Groups;

use LaravelZero\Framework\Commands\Command;
use App\Traits\T4;

class GroupCreate extends Command
{
    use T4;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:create {name} {description?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates a group';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $description = $this->argument('description');

        $url = '/group';
        $data = $this->sendRequest($url, 'post', [
            'name' => $name,
            'description' => $description
        ]);

        $this->info("Success: Created group {$name}");
    }

}
