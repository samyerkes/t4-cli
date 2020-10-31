<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        "id",
        "notificationType",
        "notificationStatus",
        "createdTime",
        "executionTime",
        "completionTime",
        "properties", 
        "users",
        "scheduled"
    ];

    protected $appends = [
        'user',
        'log',
        'type'
    ];

    public function getDefaultFields()
    {
        return $this->default;
    }
    
    public function getOptionalFields()
    {
        return $this->optional;
    }

    public function getUserAttribute()
    {
        return $this->users[0]['fullName'] ?? '';
    }
    
    public function getLogAttribute()
    {
        return $this->properties['logFileName'] ?? '';
    }
    
    public function getTypeAttribute()
    {
        return $this->properties['type'] ?? '';
    }
    
}