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
        
            $writeOption = $this->choice('Looks like you already have a configuration file. What do you want to do?', ['Append', 'Overwrite'], 0);
        
        } else {

            $writeOption = 'create';
        
        }

        $profileName = $this->ask('What do you want to call this profile?', 'default');

        $base = $this->ask('What is the base url of the T4 instance you\'re working with?', 'https://cms.school.edu');

        $webapi = $this->ask('What is the web api url of the T4 instance you\'re working with?', $base . '/terminalfour/rs');

        $token = $this->secret('What is the api token you want you use?');
        
        $configurationString = "[$profileName]\nt4_url=\"$base\"\nt4_webapi=\"$webapi\"\nt4_token=\"$token\"\n";

        if ($this->confirm('We are about to ' . strtolower($writeOption) .  ' your configuration file with this new profile. Are you sure you want to continue?')) {

            $storage = Storage::disk('home');
            
            if ($writeOption == 'Append') {
                $storage->append($configurationFile, $configurationString);
            } else {
                $storage->put($configurationFile, $configurationString);
            }

            $this->line('Profile configuration updated.');

        } else {
            
            $this->line('Profile configuration cancelled.');
        
        }
        
    }

}
