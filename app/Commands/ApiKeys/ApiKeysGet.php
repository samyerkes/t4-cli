<?php

namespace App\Commands\ApiKeys;

use App\Command;
use App\Factories\KeyFactory;

class ApiKeysGet extends Command
{
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'key:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of API keys';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'key',
        'keys',
        'key:list',
        'keys:get',
        'keys:list'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'id' ,
        'name',
        "userId",
        'invalidationDate' 
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "active",
        "deleted",
        "dateModified",
        "dateCreated",
        "expired"
    ];

    public function handle()
    {   
        $data = $this->getDetails('apikey', $this->argument('details'));

        $factory = new KeyFactory();
        $keys = $factory->generate($data);
        $firstKey = $keys->first();

        $this->print($keys, $firstKey->getTimestampFields()) ;
    }

}
