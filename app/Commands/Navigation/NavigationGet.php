<?php

namespace App\Commands\Navigation;

use App\Command;
use App\Factories\NavigationFactory;

class NavigationGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'navigation:get {details?*}
                            {--fields=id,name,group : Instead of returning the whole navigation item, returns the value of a specified field.}
                            {--filter= : Instead of returning all navigation items, returns the api keys who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of navigations';

    public function configure(): void
    {
        $this->setAliases([
            'nav',
            'nav:get',
            'nav:list',
            'navigation',
            'navigations',
            'navigation:list',
            'navigations:get',
            'navigation:list'
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

        $data = $this->getDetails('navigation', $this->details);

        $factory = new NavigationFactory();
        $navigations = $factory->generate($data);
        
        $this->print($navigations);
    }

}
