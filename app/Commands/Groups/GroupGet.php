<?php

namespace App\Commands\Groups;

use App\Command;

class GroupGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'group:get {details?*}
                            {--fields=id,name : Instead of returning the whole group, returns the value of a specified field.}
                            {--filter= : Instead of returning all groups, returns the groups who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get details about a group';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // Arguments and options
        $this->getOptions();

        // Get the details of users passed into the command
        $data = $this->getDetails('group', $this->details);
        
        if (count($data)) {
            
            // If the command has the label flag then just do an early return. 
            if ($this->labels) return $this->printLabels($data);

            $data = $this->getFilteredContent($data, $this->filters);
            
            $data = $this->getFieldsOfContent($data, $this->fields);
    
            $data = $this->sortContent($data, $this->sort, $this->order);
    
            $this->printWithFormatter($data, $this->format);
        }

    }

}
