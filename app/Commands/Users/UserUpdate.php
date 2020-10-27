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
                            {--deleted=}
                            {--l|labels : Prints the available labels you can use in the fields option.}';

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
            $editableAttributes = [
                "firstName",
                "lastName",
                "emailAddress",
                "defaultLang",
                "enabled",
                "role",
                "deleted"
            ];
            
            foreach($editableAttributes as $attr)
            {
                if (!array_key_exists($attr, $this->option())) break; 
                $currentValue = $user[$attr] ?? null;
                $user->$attr = $this->option($attr) ?? $currentValue;
            }
            
            // Send the Update request
            $request = $this->sendRequest(__('api.user.show', ['user' => $user->id]), 'put', $user->toArray());
            
            $this->info(__('actions.update', ['model' => 'User', 'user' => $user->username]));
        }

    }

}
