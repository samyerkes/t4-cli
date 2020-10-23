<?php

namespace App;

use App\Traits\Customizable;
use App\Traits\T4able;
use LaravelZero\Framework\Commands\Command as LaravelCommand;

class Command extends LaravelCommand
{
    use Customizable, T4able;
    
}
