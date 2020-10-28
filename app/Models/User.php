<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        "id",
        "username",
        "firstName",
        "lastName",
        "emailAddress",
        "defaultLang",
        "enabled",
        "authLevel",
        "deleted",
        "role",
        "password",
        "authenticationMappingList"
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'deleted' => 'boolean',
    ];

    protected $appends = [
        'role'
    ];

    protected $default = [
        "id",
        "name",
        "role"
    ];
    
    protected $optional = [
        "firstName",
        "lastName",
        "emailAddress",
        "defaultLang",
        "enabled",
        "authLevel",
        "deleted"
    ];

    public function getDefaultFields()
    {
        return $this->default;
    }
    
    public function getOptionalFields()
    {
        return $this->optional;
    }

    public function getRoleAttribute() {
        $level = $this->userLevel ?? $this->authLevel;
        return [
            0 => "admin",
            40 => "power",
            1 => "moderator",
            2 => "contributor",
            50 => "visitor"
        ][$level];
    }

    public function setRoleAttribute($value)
    {
        $this->attributes['userLevel'] = [
            "admin" => 0,
            "power" => 40,
            "moderator" => 1,
            "contributor" => 2,
            "visitor" => 50
        ][$value];
    }
    
}