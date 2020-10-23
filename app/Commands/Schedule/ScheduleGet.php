<?php

namespace App\Commands\Schedule;

use App\Command;

class ScheduleGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'schedule:get {details?*}
                            {--fields=id,name,nextDue : Instead of returning the whole schedule, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all schedules, returns the schedules who only match a specific filter. (optional)}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of scheduled jobs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Assign fields that are actually timestamps
        $timestampFields = [
            'creationDate',
            'nextDue'
        ];

        // Arguments and options
        $this->getOptions();

        // Get the details of schedules passed into the command
        $data = $this->getDetails('schedule', $this->details);

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
