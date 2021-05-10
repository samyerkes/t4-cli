<?php

namespace App\Commands\Groups;

use App\Command;
use App\Factories\GroupFactory;

use Symfony\Component\Console\Input\InputArgument;

class GroupCreate extends Command
{

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $name = 'group:create';

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

    protected $fields = [
        'name'
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "description",
        "emailAddress",
        "enabled"
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
                'name' => $this->argument('details')[0],
                'description' => $this->option('description'),
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

    /**
     * Get the console command options.
     * We need to add to the default options so we'll merge these in with the parent::getOptions() method.
     *
     * @return array
     * https://laravel.com/docs/4.2/commands
     */
    public function getOptions()
    {
        $options = [
            ['description', null, InputArgument::OPTIONAL, 'If you want to include a group description'],
            ['emailAddress', null, InputArgument::OPTIONAL, 'If you want to include an email address for the group'],
            ['enabled', null, InputArgument::OPTIONAL, 'If you want the group to be enabled by default', true]
        ];

        return array_merge(parent::getOptions(), $options);
    }

}
