<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        "id",
        "parent",
        "name",
        "description",
        "status",
        "workflow",
        "show",
        "eForm",
        "archive",
        "lastModified",
        "printSequence",
        "contentSortMethod",
        "sectionSortMethod",
        "path",
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

    public function getPathAttribute($value)
    {
        return str_replace("&raquo;", '>', $value);
    }
    
}