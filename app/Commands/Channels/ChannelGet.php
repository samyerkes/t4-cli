<?php

namespace App\Commands\Channels;

use App\Command;
use App\Factories\ChannelFactory;

class ChannelGet extends Command
{ 
    protected $name = 'channel:get';

    protected $description = 'Get a list of channels';

    protected $aliases = [
        'channel',
        'channels',
        'channel:list',
        'channels:get',
        'channels:list'
    ];

    protected $fields = [
        'id',
        'name',
        'rootSectionID'
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $option = $this->option('microsite') ? 'channelmicrosite' : 'channel';
        $option = 'channel';
        
        $data = $this->getDetails($option, $this->argument('details'));

        $factory = new ChannelFactory();
        $channels = $factory->generate($data);
        
        $this->print($channels);
    }

}
