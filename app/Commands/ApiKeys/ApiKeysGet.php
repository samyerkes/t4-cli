<?php

namespace App\Commands\ApiKeys;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ApiKeysGet extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'key:get {keys?*}
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
        $keys = $this->argument('keys');
        $labels = $this->option('labels');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));

        // Get the details of keys passed into the command
        $data = $this->getDetails('apikey', $keys);

        if (count($data)) {

            // If the command has the label flag then just do an early return. 
            if ($labels) return $this->printLabels($data);
        
            $data = $this->getFilteredContent($data, $filter);
            
            $data = $this->getFieldsOfContent($data, $fields);
    
            $data = $this->convertTimestampToHumanReadable($data, $timestampFields);

            $data = $this->sortContent($data, $sortField, $sortOrder);
    
            $this->printWithFormatter($data, $format);
        }
        
    }

}
