<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $fillable = [
        "id",
        "name",
        "description",
        "navigationType",
        "navigationTypeName",
        "editable",
        "primaryGroup",
        "sharedGroups",
        "sharedGroupCount",
    ];

    protected $appends = [
        'group',
        'sharedgroup'
    ];

    protected $default = [
        "id",
        "name"
    ];
    
    protected $optional = [
        "description",
        "navigationType",
        "navigationTypeName",
        "editable",
        "group",
        "sharedgroup",
        "sharedGroupCount"
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