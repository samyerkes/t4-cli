<?php

namespace App;

use App\Traits\Customizable;
use App\Traits\T4able;
use LaravelZero\Framework\Commands\Command as LaravelCommand;

class Command extends LaravelCommand
{
    use Customizable, T4able;

    /**
     * Gets arguments from the command
     */
    public function getOptions()
    {
        $this->details = $this->argument('details');
        $this->sort = $this->option('sort');
        $this->order = $this->option('order');
        $this->format = $this->option('format');
        $this->labels = $this->option('labels');
        $this->fields = $this->fields($this->option('fields'));
        $this->filters = $this->filter($this->option('filter'));
    }
    
}
