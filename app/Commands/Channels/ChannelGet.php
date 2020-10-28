<?php

namespace App\Commands\Channels;

use App\Command;
use App\Factories\ChannelFactory;

class ChannelGet extends Command
{ 
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'channel:get {details?*}
                            {--fields=id,name,rootSectionID : Instead of returning the whole channel, returns the value of a specified field.}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--m|microsite}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of channels';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();

        $option = $this->option('microsite') ? 'channelmicrosite' : 'channel';
        
        $data = $this->getDetails($option, $this->details);

        $factory = new ChannelFactory();
        $channels = $factory->generate($data);
        
        $this->print($channels);
    }

}
