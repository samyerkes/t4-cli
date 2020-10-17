<?php

namespace App\Commands\About;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class AboutGeneral extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'about
                        {--fields=hostname,t4,uptime,os : Return specific fields about the general about information.}
                        {--format=table}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get details about the application, host and os';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $url = __('api.about.index');
        
        $data = $this->sendRequest($url);
        
        $data = [
            [
                't4' => implode(" ", $data['t4']['version']),
                'uptime' => $data['t4']['uptime'],
                'hostname' => $data['os']['localHostname'],
                'java' => $data['java']['home'],
                'os' => $data['os']['name'] . ' ' . $data['os']['arch'],
                'user' => implode(" ", $data['user']),
                'servlet' => implode(" ", $data['servlet']),
                
            ]
        ];

        $fields = $this->fields($this->option('fields'));
        
        $format = $this->option('format');

        $data = array_values($data);
        
        $data = $this->getFieldsOfContent($data, $fields);
        
        $this->printWithFormatter($data, $format);
        
    }

}
