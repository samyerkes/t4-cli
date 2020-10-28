<?php

namespace App\Commands\Users;

use App\Command;
use App\Factories\UserFactory;

class UserGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'user:get {details?*}
                            {--fields=id,username,role : Instead of returning the whole user, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of users';

    protected function configure(): void
    {
        $this->setAliases([
            'user',
            'users',
            'user:list',
            'users:get',
            'users:list'
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();

        $data = $this->getDetails('user', $this->details);

        $factory = new UserFactory();
        $users = $factory->generate($data);

        $this->print($users);
    }

}
