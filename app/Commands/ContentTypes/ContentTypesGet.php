<?php

namespace App\Commands\ContentTypes;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ContentTypesGet extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'contenttype:get {contentTypeDetails*}
                            {--fields=id,alias,description : Return specific fields.}
                            {--format=table}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets details about one or more specific content types.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * Note: the content type name is the original name added to the system. This command will use the alias attribute since that's the up to date attribute that people would normally use to look up a content type.
         */
        $contentTypeDetails = $this->argument('contentTypeDetails');
        
        $url = '/contenttype';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $format = $this->option('format');

        $data = $data->filter( function($d) use ($contentTypeDetails) {
            $attr = ['id', 'alias'];
            foreach($attr as $a) {
                if (in_array($d[$a], $contentTypeDetails)) return true;
            }
            return false;
        });
        
        $data = $data->toArray();

        $data = array_values($data);

        $data = $this->getFieldsOfContent($data, $fields);

        $sortField = $this->option('sort');

        $sortOrder = $this->option('order');

        $data = $this->sortContent($data, $sortField, $sortOrder);

        $this->printWithFormatter($data, $format);

    }

}
