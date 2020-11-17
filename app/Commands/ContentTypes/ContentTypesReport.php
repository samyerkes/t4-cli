<?php

namespace App\Commands\ContentTypes;

use App\Command;
use App\Factories\ContentTypeFactory;

class ContentTypesReport extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'contenttype:report';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get details on where a content type is being used';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'ct:report',
        'ct:usage',
        'contenttype:usage',
        'contenttypes:usage',
        'contenttypes:report',
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        "section",
        "content",
        "name"
    ];

    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "lastModified",
        "lastModifiedBy",
        "sectionPath",
        "status",
        "orphaned"
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getOptions();

        $data = $this->getDetails('contenttype', $this->argument('details'));
        $factory = new ContentTypeFactory();
        $contenttypes = $factory->generate($data);
        $contenttype = $contenttypes->first();

        if ($contenttype) {

            $postData = [
                'resourceID' => $contenttype->id,
                'language' => 'en'
            ];
    
            $request = $this->sendRequest(__('api.report.contenttypePost'), 'post', $postData);

        }

        if ($request['id']) {

            $report = $this->sendRequest(__('api.report.contenttype', ['id' => $request['id']]), 'get');
    
            $data = collect($report['rows']);
    
            $data = $data->map(function ($row) {
                return [
                    'section' => $row['section']['parentId'],
                    'sectionPath' => $row['section']['parentPath'],
                    'content' => $row['content']['id'],
                    'name' => $row['content']['text'],
                    'lastModifiedBy' => $row['lastModifiedBy'],
                    'lastModified' => $row['lastModified'],
                    'status' => $row['status'],
                    'orphaned' => $row['orphaned'],
                    
                ];
            });
    
            $this->print($data);

        }
    }

}
