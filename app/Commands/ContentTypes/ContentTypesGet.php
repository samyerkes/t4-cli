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
    protected $signature = 'contenttype:get {contenttypes?*}
                            {--fields=id,alias,description : Return specific fields.}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
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
         * Note: The content type name is the original name added to the system. This command will use the alias attribute since that's the up to date attribute that people would normally use to look up a content type.
         */

        // Arguments and options
        $contenttypes = $this->argument('contenttypes');
        $labels = $this->option('labels');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));

        // Get the details of users passed into the command
        $data = $this->getDetails('contenttype', $contenttypes);

        if (count($data)) {

            // If the command has the label flag then just do an early return. 
            if ($labels) return $this->printLabels($data);
        
            $data = $this->getFilteredContent($data, $filter);
            
            $data = $this->getFieldsOfContent($data, $fields);
    
            $data = $this->sortContent($data, $sortField, $sortOrder);
    
            $this->printWithFormatter($data, $format);
        }

    }

}
