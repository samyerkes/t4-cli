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
        return $data->toArray();
    }

    public function getFieldsOfContent($data, $fields) : array
    {
        // if a single piece of data wrap it in an array to make it multidimensional
        $data = array_key_exists(0, $data) ? $data : [$data];
        
        $fieldsArray = [];
        foreach ($data as $d) {
            $element = [];
            foreach ($fields as $field) {
                $element[$field] = $d[$field];
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
            default:
                $this->table(array_keys($data[0]), $data);
        }
    }
    
}
