<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        "pendingVersionOutputDir",
        "rootSectionID",
        "hasPendingVersion",
        "editable",
        "microSites",
        "id",
        "name",
        "description",
    ];

    protected $default = [
        "id",
        "name",
        "rootSectionID",
    ];
    
    protected $optional = [
        "description",
    ];

    public function getDefaultFields()
    {
        return $this->default;
    }
    
    public function getOptionalFields()
    {
        return $this->optional;
    }
    
}