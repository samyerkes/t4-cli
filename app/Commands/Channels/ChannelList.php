<?php

namespace App\Commands\Channels;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ChannelList extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'channel:list
                            {--fields=name : Instead of returning the whole channel, returns the value of a specified field.}
                            {--filter= : Instead of returning all channels, returns the channels who only match a specific filter.}
                            {--format=table}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List channels';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = '/channel';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $filter = $this->filter($this->option('filter'));
        
        $format = $this->option('format');

        $data = $this->getFilteredContent($data, $filter);

        $data = $this->getFieldsOfContent($data, $fields);

        $this->printWithFormatter($data, $format);

    }

}
