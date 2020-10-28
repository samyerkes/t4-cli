<?php

namespace App\Commands\ApiKeys;

use App\Command;
use App\Factories\KeyFactory;

class ApiKeysGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'key:get {details?*}
                            {--fields=id,name,userId,invalidationDate : Instead of returning the whole api key, returns the value of a specified field.}
                            {--filter= : Instead of returning all api keys, returns the api keys who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of API keys';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $this->getOptions();

        $data = $this->getDetails('apikey', $this->details);

        $factory = new KeyFactory();
        $keys = $factory->generate($data);
        $firstKey = $keys->first();

        $this->print($keys, $firstKey->getTimestampFields()) ;
    }

}
