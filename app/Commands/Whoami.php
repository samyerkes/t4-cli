<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command as Command;
use App\Traits\T4able;
use App\Traits\Customizable;

class Whoami extends Command
{
    use T4able, Customizable;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'whoami
                            {--fields=username,emailAddress,firstName,lastName : Instead of returning the whole user, returns the value of a specified field. (optional)}
                            {--format=table}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Displays information about the auth\'d user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $url = '/profile';
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $format = $this->option('format');

        $data = $data->toArray();

        $data = $this->getFieldsOfContent($data, $fields);

        $this->printWithFormatter($data, $format);
    }

}
