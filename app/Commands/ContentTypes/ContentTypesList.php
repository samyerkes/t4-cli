<?php

namespace App\Commands\ContentTypes;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ContentTypesList extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'contenttype:list
                            {--fields=id,alias : Instead of returning the whole content type, returns the value of a specified field.}
                            {--filter= : Instead of returning all content types, returns the content types who only match a specific filter.}
                            {--format=table}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List content types';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = __('api.contenttype.index');

        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $filter = $this->filter($this->option('filter'));
        
        $format = $this->option('format');

        $data = $this->getFilteredContent($data, $filter);
        
        $data = $this->getFieldsOfContent($data, $fields);
        
        $sortField = $this->option('sort');

        $sortOrder = $this->option('order');

        $data = $this->sortContent($data, $sortField, $sortOrder);

        $this->printWithFormatter($data, $format);

    }

}
