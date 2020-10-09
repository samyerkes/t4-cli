<?php

namespace App\Commands\Transfers;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\Customizable;
use App\Traits\T4able;

class TransferList extends Command
{
    use Customizable, T4able;
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'transfer:list
                            {--fields=id,name,remoteHost,remoteRoot,channelID : Instead of returning the whole transfer, returns the value of a specified field. (optional)}
                            {--filter= : Instead of returning all transfers, returns the transfers who only match a specific filter. (optional)}
                            {--format=table}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List transfers';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $url = __('api.transfer.index');
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $filter = $this->filter($this->option('filter'));
        
        $format = $this->option('format');

        $data = $this->getFilteredContent($data, $filter);
        
        $data = $this->getFieldsOfContent($data, $fields);
        
        $sortField = $this->option('sort');

        $sortOrder = $this->option('order');

        $data = $this->sortContent($data, $sortField, $sortOrder);

        $this->printWithFormatter($data, $format);

    }

}
