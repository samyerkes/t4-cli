<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Customizable;

class Schedule extends Model
{
    use Customizable;

    protected $fillable = [
        "jobClass",
        "id",
        "name",
        "status",
        "creationDate",
        "nextDue",
        "fixedRate",
        "executionInterval",
        "executionCount",
        "executionClass",
        "maximumExecutions",
        "archiveContentID",
        "archiveSection",
        "sourceSection"
    ];

    public $timestamps = [
        'creationDate',
        'nextDue'
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