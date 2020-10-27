<?php

namespace App\Commands\Groups;

use App\Command;

class GroupCreate extends Command
{

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:create {name} {description?}
                            {--defaultPreviewChannel=}
                            {--emailAddress=}
                            {--enabled=1}';

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
        $emailAddress = $this->option('emailAddress');
        $enabled = $this->option('enabled');

        $url = __('api.group.index');
        $data = $this->sendRequest($url, 'post', [
            'name' => $name,
            'description' => $description,
            'defaultPreviewChannel' => $defaultPreviewChannel,
            'emailAddress' => $emailAddress
        ]);

        $this->info("Success: Created group {$name}");
    }

}
