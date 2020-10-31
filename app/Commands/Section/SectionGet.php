<?php

namespace App\Commands\Section;

use App\Command;
use App\Factories\SectionFactory;

class SectionGet extends Command
{
    
    /**
     * The name of the command.
     *
     * @var string
     */
    protected $name = 'section:get';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Get a list of sections';

    /**
     * The aliases of the command.
     *
     * @var array
     */
    protected $aliases = [
        'section',
        'sections'
    ];

    /**
     * The default fields the command will return.
     *
     * @var array
     */
    protected $fields = [
        "id",
        "name",
        "status",
        "lastModified",
        "path"
    ];
    
    /**
     * The optional fields the command will return.
     *
     * @var array
     */
    protected $optionalFields = [
        "description",
        "parent",
        "status",
        "workflow",
        "show",
        "eForm",
        "archive",
        "printSequence",
        "contentSortMethod",
        "sectionSortMethod",
        "mirrorOf",
        "sourceOfMirror",
        "link",
        "channels",
        "userIDs",
        "groupIDs",
        "viewUserIDs",
        "viewGroupIDs",
        "contentTypeScopes",
        "metaDatas",
        "excludedMirrorSections",
        "accessControl",
        "metaData",
        "pathMembers",
        "sortLock",
        "accessControlType",
        "metaDataType",
        "output",
        "access",
        "seo",
        "webdav",
        "enableOutputUri",
        "enableOutputFilename",
        "enableSpellCheck",
        "enablePathAsOutputUri",
        "enablePublish",
        "editable",
        "inheritedLinkSection",
        "accessControlEnabled",
        "accessControlInherited",
    ];

    protected $timestamps = [
        'lastModified'
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = $this->getDetails('section', $this->argument('details'));
        $data = [$data->toArray()];

        $factory = new SectionFactory();
        $sections = $factory->generate($data);
        
        $this->print($sections, $this->timestamps);
    }

}
