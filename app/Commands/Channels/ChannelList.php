<?php

namespace App\Commands\Channels;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4;

class ChannelList extends Command
{
    use T4;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'channel:list
                            {--fields=name : Instead of returning the whole channel, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all channels, returns the channels who only match a specific filter. (optional)}';

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
        $fields = $this->option('fields');
        $filter = $this->option('filter');
        $fields = explode(',', $fields);
        $filter = explode(':', $filter);

        $url = '/channel';
        $data = $this->sendRequest($url);

        $data = $this->getFilteredContent($data, $filter);

        $data->each(function ($channel) use ($fields) {
            $output = $this->formatOutput($channel, $fields);
            $this->line($output);
        });

    }

}
