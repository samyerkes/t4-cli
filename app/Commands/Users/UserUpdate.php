<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserUpdate extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:update {details?*}
                            {--firstName=}
                            {--lastName=}
                            {--emailAddress=}
                            {--defaultLang=}
                            {--enabled=}
                            {--role=}
                            {--deleted=}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Updates details about a user';

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
            $options = array_filter($this->option()); // gets rid of null values
            $user->fill($options);
            
            // Send the Update request
            $request = $this->sendRequest(__('api.user.show', ['user' => $user->id]), 'put', $user->toArray());
            
            $this->info(__('actions.update', ['model' => 'User', 'detail' => $user->username]));
        }

    }

}
