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
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "java",
        "user",
        "servlet"
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
        
        $builtData = [
            't4' => isset($data['t4']['version']) ? implode(" ", $data['t4']['version']) : '',
            'uptime' => isset($data['t4']['uptime']) ? $data['t4']['uptime'] : '',
            'hostname' => $data['os']['localHostname'],
            'java' => isset($data['java']) ? "Version " . $data['java']['version'] . ' ' . $data['java']['home'] : '',
            'os' => isset($data['os']) ? $data['os']['name'] . ' ' . $data['os']['arch'] : '',
            'user' => isset($data['user']) ? implode(" ", $data['user']) : '',
            'servlet' => isset($data['servlet']) ? implode(" ", $data['servlet']) : ''
        ];

        $this->print([$builtData]);
        
    }

}
