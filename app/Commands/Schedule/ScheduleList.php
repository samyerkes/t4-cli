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
                            {--fields=name : Instead of returning the whole schedule, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all schedules, returns the schedules who only match a specific filter. (optional)}';

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
        $fields = $this->fields($this->option('fields'));
        
        $filter = $this->filter($this->option('filter'));

        $url = '/schedule';
        $data = $this->sendRequest($url);

        $data = $this->getFilteredContent($data, $filter);

        $data->each(function ($schedule) use ($fields) {
            $output = $this->formatOutput($schedule, $fields);
            $this->line($output);
        });

    }

}
