<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

use Symfony\Component\Console\Input\InputArgument;

class UserCreate extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $name = "user:create";

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = "Creates a user";

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        "user:new",
        "users:new",
        "users:create"
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        "firstName",
        "lastName",
        "username",
        "password",
        "emailAddress"
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "role",
        "authentication",
        "enabled",
        "defaultLanguage"
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Note, this command is throwing a 500 error, but it's also throwing a 500 error in the example postman collection.
        [$firstName, $lastName, $username, $password, $emailAddress] = $this->argument('details');
        $data = [
            [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'username' => $username,
                'password' => $password,
                'emailAddress' => $emailAddress,
                'role' => strtolower($this->option('role')),
                'defaultLanguage' => $this->option('defaultLanguage'),
                'userInterfaceLanguage' => $this->option('defaultLanguage'),
                'authenticationMappingList' => [
                    [
                        'id' => 1,
                        "enabled" => true
                    ]
                ],
                'enabled' => $this->option('enabled')
            ]
        ];

        $factory = new UserFactory();
        $users = $factory->generate($data);

        $users->each(function($user) {
            $request = $this->sendRequest(__('api.user.index'), 'post', $user->toArray());
            $this->info(__('actions.create', ['model' => 'User', 'detail' => $user->username]));
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
            ['role', null, InputArgument::OPTIONAL, 'If you want to the user to have a specific role, defaults to Contributor', 'contributor'],
            ['enabled', null, InputArgument::OPTIONAL, 'If you want the user to be enabled by default', true],
            ['defaultLanguage', null, InputArgument::OPTIONAL, 'If you want the group to be enabled by default', 'en'],
        ];

        return array_merge(parent::getOptions(), $options);
    }

}
