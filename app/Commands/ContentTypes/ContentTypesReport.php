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
<<<<<<< HEAD
        "name",
        "lastModified",
        "lastModifiedBy",
    ];
    
=======
        "name"
    ];

>>>>>>> 76a31c7d0877004091df40f9ba27e21307a80235
    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
<<<<<<< HEAD
=======
        "lastModified",
        "lastModifiedBy",
>>>>>>> 76a31c7d0877004091df40f9ba27e21307a80235
        "sectionPath",
        "status",
        "orphaned"
    ];
<<<<<<< HEAD
    
    protected $timestampFields = [
        "lastModified",
    ];
=======
>>>>>>> 76a31c7d0877004091df40f9ba27e21307a80235

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
<<<<<<< HEAD

            $this->print($data, $this->timestampFields);
=======
    
            $this->print($data);
>>>>>>> 76a31c7d0877004091df40f9ba27e21307a80235

        }
    }

}
