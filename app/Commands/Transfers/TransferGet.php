<?php

namespace App\Commands\Transfers;

use App\Command;

class TransferGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'transfer:get {details?*}
                            {--fields=id,name,remoteHost,remoteRoot,channelID : Instead of returning the whole transfer, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all transfers, returns the transfers who only match a specific filter. (optional)}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of transfers';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Arguments and options
        $this->getOptions();

        // Get the details of keys passed into the command
        $data = $this->getDetails('transfer', $this->details);

        if (count($data)) {

            // If the command has the label flag then just do an early return. 
            if ($this->labels) return $this->printLabels($data);
        
            $data = $this->getFilteredContent($data, $this->filters);
            
            $data = $this->getFieldsOfContent($data, $this->fields);
    
            $data = $this->sortContent($data, $this->sort, $this->order);
    
            $this->printWithFormatter($data, $this->format);
        }

    }

}
