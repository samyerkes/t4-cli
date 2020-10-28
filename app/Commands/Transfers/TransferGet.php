<?php

namespace App\Commands\Transfers;

use App\Command;
use App\Factories\TransferFactory;

class TransferGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'transfer:get {details?*}
                            {--fields=id,name,remoteHost : Instead of returning the whole transfer, returns the value of a specified field. (optional)}
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

    protected function configure(): void
    {
        $this->setAliases([
            'transfer',
            'transfers',
            'transfer:list',
            'transfers:get',
            'transfers:list'
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();

        $data = $this->getDetails('transfer', $this->details);

        $factory = new TransferFactory();
        $transfers = $factory->generate($data);

        $this->print($transfers);
    }

}
