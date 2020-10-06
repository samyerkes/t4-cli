<?php

namespace App\Commands\Channels;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4able;

class ChannelGet extends Command
{
    use T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'channel:get {channel}
                            {--fields=name : Instead of returning the whole channel, returns the value of a specified field. (optional)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Gets details about a channel';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $channel = $this->argument('channel');
        $fields = $this->option('fields');
        $fields = explode(',', $fields);

        $url = '/channel';
        $data = $this->sendRequest($url);

        $channel = $data->firstWhere('name', $channel);

        $output = $this->formatOutput($channel, $fields);
        $this->line($output);

    }

}
