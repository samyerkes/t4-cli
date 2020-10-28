<?php

namespace App\Factories;

use App\Command;
use App\Models\Schedule;
use App\Traits\T4able;

class ScheduleFactory {

    use T4able;

    public function generate($data) 
    {
        $schedules = collect([]);
        foreach ($data as $schedule) 
        {
            $scheduleDTO = new Schedule;
            $scheduleDTO = $scheduleDTO->fill($schedule);
            $schedules->push($scheduleDTO);
        }
        return $schedules;
    }
}