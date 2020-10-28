<?php

namespace App\Commands\Layouts;

use App\Command;
use App\Factories\LayoutFactory;

class LayoutsGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'layout:get {details?*}
                            {--fields=id,name,description,group : Instead of returning the whole layout, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all layouts, returns the layouts who only match a specific filter. (optional)}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of layouts';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();
        
        $data = $this->getDetails('layout', $this->details);
        
        $factory = new LayoutFactory();
        $layouts = $factory->generate($data);
        
        $this->print($layouts);
    }

}
