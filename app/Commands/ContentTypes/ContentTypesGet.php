<?php

namespace App\Commands\ContentTypes;

use App\Command;
use App\Factories\ContentTypeFactory;

class ContentTypesGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'contenttype:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of content types';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'ct',
        'ct:get',
        'ct:list',
        'contenttype',
        'contenttypes',
        'contenttype:list',
        'contenttypes:get',
        'contenttypes:list'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'id' ,
        'alias',
        'group' 
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "description",
        "name",
        "sharedgroup"
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();

        $data = $this->getDetails('contenttype', $this->argument('details'));

        $factory = new ContentTypeFactory();
        $contenttypes = $factory->generate($data);

        $this->print($contenttypes);
    }

}
