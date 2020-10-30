<?php

namespace App\Commands;

use App\Command;
use App\Factories\UserFactory;

class Whoami extends Command
{

    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'whoami';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Displays information about the auth\'d user';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'who',
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'username' ,
        'role',
        'emailAddress',
        'firstName',
        'lastName' 
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = __('api.profile');
        
        $data = $this->sendRequest($url);

        $data = [$data];

        $factory = new UserFactory();
        $users = $factory->generate($data);

        $this->print($users);
    }

}
