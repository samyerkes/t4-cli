<?php

namespace App\Commands\Schedule;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4;

class ScheduleList extends Command
{
    use T4;
    
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
        $fields = $this->option('fields');
        $filter = $this->option('filter');
        $fields = explode(',', $fields);
        $filter = explode(':', $filter);

        $url = '/schedule';
        $data = $this->getContent($url);

        $data = $this->getFilteredContent($data, $filter);

        $data->each(function ($schedule) use ($fields) {
            $output = $this->formatOutput($schedule, $fields);
            $this->line($output);
        });

    }

}
