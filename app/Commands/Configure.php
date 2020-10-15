<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use Storage;

class Configure extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'configure';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Configures the CLI to point to your installation of T4';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $configurationFile = '.t4';
        
        if (Storage::disk('home')->exists($configurationFile)) {
        
            $override = $this->confirm('Looks like you already have a configuration file. Do you want to override it with a new one?');
            
            if(!$override) return;
        
        }

        $profileName = $this->ask('What do you want to call this profile?', 'default');

        $base = $this->ask('What is the base url of the T4 instance you\'re working with?', 'https://cms.school.edu');

        $webapi = $this->ask('What is the web api url of the T4 instance you\'re working with?', $base . '/terminalfour/rs');

        $token = $this->ask('What is the api token you want you use?');
        
        $configurationString = "[$profileName]\nt4_url=\"$base\"\nt4_webapi=\"$webapi\"\nt4_token=\"$token\"";
        
        Storage::disk('home')->put($configurationFile, $configurationString);
    }

}
