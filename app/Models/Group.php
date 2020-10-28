<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        "id",
        "name",
        "description",
        "emailAddress",
        "defaultPreviewChannel",
        "membersCount",
    ];

    protected $default = [
        "id",
        "name",
        "membersCount"
    ];
    
    protected $optional = [
        "defaultPreviewChannel",
        "description",
        "emailAddress"
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