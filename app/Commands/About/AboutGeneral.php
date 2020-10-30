<?php

namespace App\Commands\About;

use App\Command;

class AboutGeneral extends Command
{ 
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'about';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get details about the application, host and os';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'info',
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'hostname' ,
        't4',
        'uptime',
        'os' 
    ];

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
                'java' => "Version " . $data['java']['version'] . ' ' . $data['java']['home'],
                'os' => $data['os']['name'] . ' ' . $data['os']['arch'],
                'user' => implode(" ", $data['user']),
                'servlet' => implode(" ", $data['servlet']),
                
            ]
        ];

        $this->print($data);
        
    }

}
