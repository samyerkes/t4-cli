<?php

namespace App\Commands\Channels;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class ChannelGet extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'channel:get {channel}
                            {--fields=id,name : Instead of returning the whole channel, returns the value of a specified field.}
                            {--format=table}';

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
        
        $data = $this->getDetails('channel', $channel)->first();

        $fields = $this->fields($this->option('fields'));

        $format = $this->option('format');

        $data = $this->getFieldsOfContent($data, $fields);

        $this->printWithFormatter($data, $format);

    }

}
