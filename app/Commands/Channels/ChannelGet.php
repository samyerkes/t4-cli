<?php

namespace App\Commands\Channels;

use App\Command;
use App\Factories\ChannelFactory;

use Symfony\Component\Console\Input\InputOption;

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
        $option = $this->option('microsite') ? 'channelmicrosite' : 'channel';
        
        $data = $this->getDetails($option, $this->argument('details'));

        $factory = new ChannelFactory();
        $channels = $factory->generate($data);
        
        $this->print($channels);
    }

    /**
     * Get the console command options.
     * We need to add to the default options so we'll merge these in with the parent::getOptions() method.
     *
     * @return array
     * https://laravel.com/docs/4.2/commands
     */
    public function getOptions()
    {
        $microsite = [['microsite', null, InputOption::VALUE_NONE, 'If you want to include microsites in the results']];

        return array_merge(parent::getOptions(), $microsite);
    }

}
