<?php

namespace App\Commands\Layouts;

use App\Command;
use App\Factories\LayoutFactory;

class LayoutsGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'layout:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of layouts';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'layout',
        'layouts',
        'layout:list',
        'layouts:get',
        'layout:list'
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();
        
        $data = $this->getDetails('layout', $this->argument('details'));
        
        $factory = new LayoutFactory();
        $layouts = $factory->generate($data);
        
        $this->print($layouts);
    }

}
