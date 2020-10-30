<?php

namespace App;

use App\Traits\Customizable;
use App\Traits\T4able;
use LaravelZero\Framework\Commands\Command as LaravelCommand;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Command extends LaravelCommand
{
    use Customizable, T4able;

    protected $fields = ['id'];

    protected $aliases = [];

    protected $format = 'table';

    protected $order = 'desc';
    
    protected $sort = 'id';

    public function configure()
    {
        $this->setAliases($this->aliases);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['details', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Narrow the search to specific ids or names'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     * https://laravel.com/docs/4.2/commands
     */
    public function getOptions()
    {
        return [
            ['fields', null, InputOption::VALUE_OPTIONAL, 'Return specific fields from a record', $this->fields],
            ['filters', null, InputOption::VALUE_OPTIONAL, 'Return only certain records that match a particular filter'],
            ['format', null, InputOption::VALUE_OPTIONAL, 'Return the records in a specific format', $this->format],
            ['labels', null, InputOption::VALUE_NONE, 'Return all default and optional fields for a command'],
            ['order', null, InputOption::VALUE_OPTIONAL, 'Order the returned records in asc or desc order', $this->order],
            ['sort', null, InputOption::VALUE_OPTIONAL, 'Sort the returned records based on a field', $this->sort]
        ];
    }

    public function print($data, $timestampFields = null)
    {
        if (count($data)) {
            if ($this->option('labels')) return $this->printLabels($data);

            $data = $this->getFilteredContent($data, $this->option('filters'));

            $data = $this->getFieldsOfContent($data, $this->option('fields'));

            if ($timestampFields) $data = $this->convertTimestampToHumanReadable($data, $timestampFields);
    
            $data = $this->sortContent($data, $this->option('sort'), $this->option('order'));
    
            $this->printWithFormatter($data, $this->option('format'));
        }
    }
    
}
