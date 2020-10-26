<?php

namespace App\Commands\Users;

use App\Command;
use App\Models\User;

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

        foreach ($data as $user) 
        {
            // Get the userDTO
            $request = $this->sendRequest(__('api.user.show', ['user' => $user['id']]), 'get', $user);
            $userDTO = User::make($request->toArray());

            
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
                $userDTO->$attr = $this->option($attr) ?? $currentValue;
            }
            
            // Send the Update request
            $request = $this->sendRequest(__('api.user.show', ['user' => $userDTO->id]), 'put', $userDTO->toArray());
            
            $this->info("User ". $userDTO->username ." successfully updated");
        }

    }

}
