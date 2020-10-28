<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $fillable = [
        "id",
        "alias",
        "name",
        "description",
        "primaryGroup",
        "group",
        "sharedGroups",
    ];

    protected $appends = [
        'group',
        'sharedgroup'
    ];

    protected $default = [
        "id",
        "alias"
    ];
    
    protected $optional = [
        "description",
        "group",
        "name",
        "sharedgroup"
    ];

    public function getDefaultFields()
    {
        return $this->default;
    }
    
    public function getOptionalFields()
    {
        return $this->optional;
    }

    public function getGroupAttribute()
    {
        return $this->primaryGroup['name'] ?? '';
    }
    
    public function getSharedGroupAttribute()
    {
        $sharedGroupArray = [];
        foreach($this->sharedGroups as $sharedGroup) {
            array_push($sharedGroupArray, "(". $sharedGroup['id'] . ") " . $sharedGroup['name']);
        }
        return implode(' ', $sharedGroupArray);
    }
    
}