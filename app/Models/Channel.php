<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        "rootSectionID",
        "editable",
        "microSites",
        "id",
        "name",
        "description",
        "parentID",
    ];

    protected $default = [
        "id",
        "name",
        "rootSectionID"
    ];
    
    protected $optional = [
        "description",
        "editable",
        "parentID"
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