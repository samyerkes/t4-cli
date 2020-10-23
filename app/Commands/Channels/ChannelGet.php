<?php

namespace App\Commands\Channels;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ChannelGet extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'channel:get {channels?*}
                            {--fields=id,name,rootSectionID : Instead of returning the whole channel, returns the value of a specified field.}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--m|microsite}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets details about a channel';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Arguments and options
        $channels = $this->argument('channels');
        $labels = $this->option('labels');
        $micrositeOption = $this->option('microsite');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));

        $option = $micrositeOption ? 'channelmicrosite' : 'channel';
        
        $data = $this->getDetails($option, $channels);

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
