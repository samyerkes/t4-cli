<?php

namespace App\Commands\ContentTypes;

use App\Command;
use App\Factories\ContentTypeFactory;

class ContentTypesGet extends Command
{
    
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'contenttype:get {details?*}
                            {--fields=id,alias,group : Return specific fields.}
                            {--filter= : Instead of returning all users, returns the users who only match a specific filter.}
                            {--format=table}
                            {--l|labels : Prints the available labels you can use in the fields option.}
                            {--sort=id}
                            {--order=desc}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of content types';

    public function configure(): void
    {
        $this->setAliases([
            'ct',
            'ct:get',
            'ct:list',
            'contenttype',
            'contenttypes',
            'contenttype:list',
            'contenttypes:get',
            'contenttypes:list'
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

        $data = $this->getDetails('contenttype', $this->details);

        $factory = new ContentTypeFactory();
        $contenttypes = $factory->generate($data);

        $this->print($contenttypes);

    }

}
