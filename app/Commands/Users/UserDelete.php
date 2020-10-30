<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserDelete extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'user:delete';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Deletes a user';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'users:delete'
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the details of users passed into the command
        $data = $this->getDetails('user', $this->argument('details'));

        $factory = new UserFactory();
        $users = $factory->generate($data);
        
        foreach ($users as $user) 
        {            
            $request = $this->sendRequest(__('api.user.show', ['user' => $user->id]), 'delete');
            
            $this->info(__('actions.delete', ['model' => 'User', 'detail' => $user->username]));
        }

    }

}
