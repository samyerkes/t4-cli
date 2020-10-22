<?php

namespace App\Commands\Schedule;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ScheduleGet extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'schedule:get {schedules?*}
                            {--fields=id,name,nextDue : Instead of returning the whole schedule, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all schedules, returns the schedules who only match a specific filter. (optional)}
                            {--format=table}
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
        $schedules = $this->argument('schedules');
        $sortField = $this->option('sort');
        $sortOrder = $this->option('order');
        $format = $this->option('format');
        $fields = $this->fields($this->option('fields'));
        $filter = $this->filter($this->option('filter'));

        // Get the details of schedules passed into the command
        $data = $this->getDetails('schedule', $schedules);

        if (count($data)) {
        
            $data = $this->getFilteredContent($data, $filter);
            
            $data = $this->getFieldsOfContent($data, $fields);
    
            $data = $this->convertTimestampToHumanReadable($data, $timestampFields);

            $data = $this->sortContent($data, $sortField, $sortOrder);
    
            $this->printWithFormatter($data, $format);
        }

    }

}
