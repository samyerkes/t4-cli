<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserDelete extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:delete {details?*}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Deletes one or more users';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Arguments and options
        $this->getOptions();

        // Get the details of users passed into the command
        $data = $this->getDetails('user', $this->details);

        $factory = new UserFactory();
        $users = $factory->generate($data);
        
        foreach ($users as $user) 
        {            
            $request = $this->sendRequest(__('api.user.show', ['user' => $user->id]), 'delete');
            
            $this->info(__('actions.delete', ['model' => 'User', 'user' => $user->username]));
        }

    }

}
