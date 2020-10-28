<?php

namespace App\Commands\Schedule;

use App\Command;
use App\Factories\ScheduleFactory;

class ScheduleGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'schedule:get {details?*}
                            {--fields=id,name : Instead of returning the whole schedule, returns the value of a specified field. (optional)}
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
        $this->getOptions();

        $data = $this->getDetails('schedule', $this->details);
        
        $factory = new ScheduleFactory();
        $schedules = $factory->generate($data);
        $firstSchedule = $schedules->first();

        $this->print($schedules, $firstSchedule->getTimestampFields());
    }

}
