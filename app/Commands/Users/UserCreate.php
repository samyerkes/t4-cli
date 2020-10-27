<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserCreate extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:create {firstName} {lastName} {username} {password} {emailAddress}
                            {--role=visitor}
                            {--authentication=1}                            
                            {--enabled=1}                            
                            {--defaultLanguage=en}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Note, this command is throwing a 500 error, but it's also throwing a 500 error in the example postman collection.
        $data = [
            [
                'firstName' => $this->argument('firstName'),
                'lastName' => $this->argument('lastName'),
                'username' => $this->argument('username'),
                'password' => $this->argument('password'),
                'emailAddress' => $this->argument('emailAddress'),
                'role' => $this->option('role'),
                'defaultLanguage' => $this->option('defaultLanguage'),
                'userInterfaceLanguage' => $this->option('defaultLanguage'),
                'authenticationMappingList' => [
                    [
                        'id' => $this->option('authentication')
                    ]
                ],
                'enabled' => $this->option('enabled')
            ]
        ];

        $factory = new UserFactory();
        $users = $factory->generate($data);

        $users->each(function($user) {
            $request = $this->sendRequest(__('api.user.index'), 'post', $user->toArray());
            $this->info(__('actions.create', ['model' => 'User', 'user' => $user->username]));
        });

    }

}
