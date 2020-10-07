<?php

namespace App\Commands\Schedule;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ScheduleList extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'schedule:list
                            {--fields=id,name,nextDue : Instead of returning the whole schedule, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all schedules, returns the schedules who only match a specific filter. (optional)}
                            {--format=table}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List schedules';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $timestampFields = [
            'creationDate',
            'nextDue'
        ];

        $url = '/schedule';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $filter = $this->filter($this->option('filter'));
        
        $format = $this->option('format');

        $data = $this->getFilteredContent($data, $filter);
        
        $data = $this->getFieldsOfContent($data, $fields);
        
        $data = $this->convertTimestampToHumanReadable($data, $timestampFields);

        $this->printWithFormatter($data, $format);

    }

}
