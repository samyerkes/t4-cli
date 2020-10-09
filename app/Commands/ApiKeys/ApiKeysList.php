<?php

namespace App\Commands\ApiKeys;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ApiKeysList extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'key:list
                            {--fields=id,name,active,userId,invalidationDate : Instead of returning the whole api key, returns the value of a specified field.}
                            {--filter= : Instead of returning all api keys, returns the api keys who only match a specific filter.}
                            {--format=table}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List API keys';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $timestampFields = [
            'lastModifiedBy',
            'dateModified',
            'dateCreated',
            'invalidationDate'
        ];

        $url = '/apikey/list';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $filter = $this->filter($this->option('filter'));
        
        $format = $this->option('format');

        $data = $this->getFilteredContent($data, $filter);

        $data = array_values($data);
        
        $data = $this->getFieldsOfContent($data, $fields);
        
        $data = $this->convertTimestampToHumanReadable($data, $timestampFields);

        $sortField = $this->option('sort');

        $sortOrder = $this->option('order');

        $data = $this->sortContent($data, $sortField, $sortOrder);

        $this->printWithFormatter($data, $format);
        
    }

}
