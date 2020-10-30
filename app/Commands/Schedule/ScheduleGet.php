<?php

namespace App\Commands\Schedule;

use App\Command;
use App\Factories\ScheduleFactory;

class ScheduleGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'schedule:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of scheduled jobs';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'schedule',
        'schedules',
        'schedule:list',
        'schedules:get',
        'schedules:list'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'id' ,
        'name',
        'nextDue' 
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();

        $data = $this->getDetails('schedule', $this->argument('details'));
        
        $factory = new ScheduleFactory();
        $schedules = $factory->generate($data);
        $firstSchedule = $schedules->first();

        $this->print($schedules, $firstSchedule->getTimestampFields());
    }

}
