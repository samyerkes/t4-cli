<?php

namespace App\Commands\Transfers;

use App\Command;
use App\Factories\TransferFactory;

class TransferGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'transfer:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of transfers';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'transfer',
        'transfers',
        'transfer:list',
        'transfers:get',
        'transfers:list'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        'id' ,
        'name',
        'remoteHost' 
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "description",
        "remoteRoot",
        "transferType",
        "channelID",
        "isCleanServer"
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();

        $data = $this->getDetails('transfer', $this->argument('details'));

        $factory = new TransferFactory();
        $transfers = $factory->generate($data);

        $this->print($transfers);
    }

}
