<?php

namespace App\Commands\Navigation;

use App\Command;

class NavigationGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'navigation:get {navigations?*}
                            {--fields=id,name,navigationTypeName : Instead of returning the whole navigation item, returns the value of a specified field.}
                            {--filter= : Instead of returning all navigation items, returns the api keys who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of navigation items';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Arguments and options
        $navs = $this->argument('navigations');
        $labels = $this->option('labels');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));

        // Get the details of keys passed into the command
        $data = $this->getDetails('navigation', $navs);

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
