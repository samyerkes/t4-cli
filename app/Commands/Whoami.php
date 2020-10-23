<?php

namespace App\Commands;

use App\Command;

class Whoami extends Command
{

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
        $url = __('api.profile');
        
        $data = $this->sendRequest($url);

        $fields = $this->fields($this->option('fields'));

        $format = $this->option('format');

        $data = $data->toArray();

        $data = $this->getFieldsOfContent($data, $fields);

        $this->printWithFormatter($data, $format);
    }

}
