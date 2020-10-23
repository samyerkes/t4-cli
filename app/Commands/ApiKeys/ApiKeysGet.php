<?php

namespace App\Commands\ApiKeys;

use App\Command;

class ApiKeysGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'key:get {details?*}
                            {--fields=id,name,active,userId,invalidationDate : Instead of returning the whole api key, returns the value of a specified field.}
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
        // Assign fields that are actually timestamps
        $timestampFields = [
            'lastModifiedBy',
            'dateModified',
            'dateCreated',
            'invalidationDate'
        ];

        // Arguments and options
        $this->getOptions();

        // Get the details of keys passed into the command
        $data = $this->getDetails('apikey', $this->details);

        if (count($data)) {

            // If the command has the label flag then just do an early return. 
            if ($this->labels) return $this->printLabels($data);
        
            $data = $this->getFilteredContent($data, $this->filters);
            
            $data = $this->getFieldsOfContent($data, $this->fields);
    
            $data = $this->convertTimestampToHumanReadable($data, $timestampFields);

            $data = $this->sortContent($data, $this->sort, $this->order);
    
            $this->printWithFormatter($data, $this->format);
        }
        
    }

}
