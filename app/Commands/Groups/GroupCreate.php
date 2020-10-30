<?php

namespace App\Commands\Groups;

use App\Command;
use App\Factories\GroupFactory;

class GroupCreate extends Command
{

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:create {name} {description?}
                            {--enabled=1}
                            {--emailAddress=}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates a group';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'groups:create',
        'group:new',
        'groups:new',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
            [
                'name' => $this->argument('name'),
                'description' => $this->argument('description'),
                'emailAddress' => $this->option('emailAddress'),
                'enabled' => $this->option('enabled')
            ]
        ];

        $factory = new GroupFactory();
        $groups = $factory->generate($data);

        $groups->each(function($group) {
            $request = $this->sendRequest(__('api.group.index'), 'post', $group->toArray());
            $this->info(__('actions.create', ['model' => 'Group', 'detail' => $group->name]));
        });

    }

}
