<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Customizable;

class Transfer extends Model
{
    use Customizable;

    protected $fillable = [
        "id",
        "name",
        "description",
        "remoteHost",
        "remoteRoot",
        "transferType",
        "channelID",
        "isCleanServer"
    ];

    protected $default = [
        "id",
        "name"
    ];
    
    protected $optional = [
        "description",
        "remoteHost",
        "remoteRoot",
        "transferType",
        "channelID",
        "isCleanServer"
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