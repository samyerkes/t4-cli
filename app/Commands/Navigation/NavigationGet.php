<?php

namespace App\Commands\Navigation;

use App\Command;
use App\Factories\NavigationFactory;

class NavigationGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'navigation:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of navigations';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'nav',
        'nav:get',
        'nav:list',
        'navigation',
        'navigations',
        'navigation:list',
        'navigations:get',
        'navigation:list'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'id' ,
        'name',
        'group' 
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "description",
        "navigationType",
        "navigationTypeName",
        "editable",
        "sharedgroup",
        "sharedGroupCount"
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->getDetails('navigation', $this->argument('details'));

        $factory = new NavigationFactory();
        $navigations = $factory->generate($data);
        
        $this->print($navigations);
    }

}
