<?php

namespace App\Commands\Groups;

use App\Command;
use App\Factories\GroupFactory;

class GroupGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:get {details?*}
                            {--fields=id,name,membersCount : Instead of returning the whole group, returns the value of a specified field.}
                            {--filter= : Instead of returning all groups, returns the groups who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of groups';

    public function configure(): void
    {
        $this->setAliases([
            'group',
            'groups',
            'group:list',
            'groups:get',
            'groups:list'
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

        $data = $this->getDetails('group', $this->details);

        $factory = new GroupFactory();
        $groups = $factory->generate($data);
        
        $this->print($groups);
    }

}
