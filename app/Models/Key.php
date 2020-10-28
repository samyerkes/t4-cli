<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Customizable;

class Key extends Model
{
    use Customizable;

    protected $fillable = [
        "id",
        "name",
        "active",
        "deleted",
        "userId",
        "dateModified",
        "dateCreated",
        "invalidationDate",
        "expired"
    ];

    protected $default = [
        "id",
        "name",
        "userId",
        "invalidationDate"
    ];
    
    protected $optional = [
        "active",
        "deleted",
        "dateModified",
        "dateCreated",
        "expired"
    ];

    public $timestamps = [
        'dateModified',
        'dateCreated',
        'invalidationDate'
    ];

    public function getDefaultFields()
    {
        return $this->default;
    }
    
    public function getOptionalFields()
    {
        return $this->optional;
    }
    
    public function getTimestampFields()
    {
        return $this->timestamps;
    }
    
}