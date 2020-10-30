<?php

namespace App\Commands\ApiKeys;

use App\Command;
use App\Factories\KeyFactory;

class ApiKeysGet extends Command
{
    protected $name = 'key:get';

    protected $description = 'Get a list of API keys';

    protected $aliases = [
        'key',
        'keys',
        'key:list',
        'keys:get',
        'keys:list'
    ];

    protected $fields = [
        'id' ,
        'name',
        'invalidationDate' 
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
