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
        "ldap",
        "enabled"
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'ldap' => 'boolean',
    ];
    
}