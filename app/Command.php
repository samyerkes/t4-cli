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
        $this->sort = $this->getOption('sort');
        $this->order = $this->getOption('order');
        $this->format = $this->getOption('format');
        $this->labels = $this->getOption('labels');
        $this->fields = $this->fields($this->getOption('fields'));
        $this->filters = $this->filter($this->getOption('filter'));
    }

    private function getOption($key)
    {
        return array_key_exists($key, $this->option()) ? $this->option($key) : "";
    }
    
}
