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
        "userLevel",
        "deleted"
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function getRoleAttribute() {
        $authNumber =  $this->authLevel;
        switch ($authNumber) {
            case 0:
                $this->attributes['userLevel'] = 0;
                return 'admin';
            case 40:
                $this->attributes['userLevel'] = 40;
                return 'power';
            case 1:
                $this->attributes['userLevel'] = 1;
                return 'moderator';
            case 2:
                $this->attributes['userLevel'] = 2;
                return 'contributor';
            case 50:
                $this->attributes['userLevel'] = 50;
                return 'visitor';
        } 
    }

    public function setRoleAttribute($value)
    {
        // This is extremely hacky but it works for now.
        if ($value == 'admin' || $value == 'administrator') $this->attributes['userLevel'] = 0;
        if ($value == 'power' || $value == 'poweruser') $this->attributes['userLevel'] = 40;
        if ($value == 'moderator' || $value == 'mod') $this->attributes['userLevel'] = 1;
        if ($value == 'contributor' || $value == 'contrib') $this->attributes['userLevel'] = 2;
        if ($value == 'visitor') $this->attributes['userLevel'] = 50;
    }
    
}