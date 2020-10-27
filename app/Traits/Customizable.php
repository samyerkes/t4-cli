<?php

namespace App\Traits;

Trait Customizable
{
    public function fields($input) 
    {
        return explode(',', $input);
    }

    public function filter($input) 
    {
        return explode(':', $input);
    }

    public function getFilteredContent($data, $filter) : array
    {
        if ($filter[0] == '') return $data->toArray();

        $data =  $data->filter(function ($d) use ($filter) {
            list($attr, $val) = $filter;
            return $d[$attr] == $val;
        });
        return $data->values()->toArray();
    }

    public function getFieldsOfContent($data, $fields) : array
    {
        // if a single piece of data wrap it in an array to make it multidimensional
        $data = array_key_exists(0, $data) ? $data : [$data];
        
        $fieldsArray = [];
        foreach ($data as $d) {
            $element = [];
            foreach ($fields as $field) {
                $element[$field] = $d[$field] ?? "";
            }
            array_push($fieldsArray, $element);
        }
        return $fieldsArray;
    }

    public function printAsIds($data) {
        foreach($data as $d) 
        {
            $this->line($d['id']);
        }
    }

    public function printAsJson($data) 
    {
        echo json_encode($data);
    }
    
    public function printAsCSV($data)
    {
        $csvDelimiter = ', ';
        // print headings
        $headings = array_keys($data[0]);
        $headings = implode($csvDelimiter, $headings);
        $this->line($headings);
        
        foreach ($data as $d) 
        {
            $csvFormat = implode($csvDelimiter, $d);
            $this->line($csvFormat);
        }
    }
    
    public function printAsCount($data)
    {
        $count = count($data);
        $this->line($count);
    }
    
    public function printAsText($data)
    {
        // Get the key we are going to print out
        $key = array_keys($data[0])[0];

        // Write out each attribute as it's own separate line
        $data = collect($data);
        $data = $data->pluck($key)
                    ->each(function($d) {
                        $this->line($d);
                    });
    }

    public function printWithFormatter($data, $format) 
    {
        switch($format) {
            case "count":
                $this->printAsCount($data);
                break;
            case "csv":
                $this->printAsCSV($data);
                break;
            case "id":
                $this->printAsIds($data);
                break;
            case "json":
                $this->printAsJson($data);
                break;
            case "text":
                $this->printAsText($data);
                break;
            default:
                $this->table(array_keys($data[0]), $data);
        }
    }

    public function convertTimestampToHumanReadable($data, $timestamps) {
        $timezone = config('app.timezone');

        // Check if any of the data that has been filtered out is a timestamp
        $first = array_keys($data[0]);
        $timestamps = array_intersect($first, $timestamps);
        
        // If not then just do an early return
        if (!$timestamps) return $data;
        
        foreach ($data as $dkey => $d) {
            foreach ($timestamps as $key) {
                $timestamp = $d[$key];
                $data[$dkey][$key] = \Carbon\Carbon::createFromTimestamp($timestamp / 1000, $timezone);
            }
        }

        return $data;
    }

    public function sortContent($data, $sortField, $sortOrder)
    {
        if (!in_array($sortOrder, array('asc', 'desc'), true )) return $data;

        $data = collect($data)->sortBy($sortField);
        if ($sortOrder == 'asc') {
            $data = $data->reverse();
        }
        return $data->toArray();
    }

    public function printLabels($data)
    {
        $first = $data[0];
        $data = array_keys($first->getAttributes());
        $this->line(implode(', ', $data));
    }
    
}
