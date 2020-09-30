<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command as LaravelCommand;

Trait T4
{

    public function getContent($url) {
        $t4key = config('t4.token');
        $t4base = config('t4.base');
        $response = Http::withToken($t4key)->get($t4base . $url);
        if ($response->ok()) return collect($response->json());
    }
    
    public function postContent($url, $data) {
        $t4key = config('t4.token');
        $t4base = config('t4.base');
        $response = Http::withToken($t4key)->post($t4base . $url, $data);
        if ($response->ok()) return collect($response->json());
    }
    
    public function sendRequest($method, $url, $data=[]) {
        $t4key = config('t4.token');
        $t4base = config('t4.base');
        $response = Http::withToken($t4key)->$method($t4base . $url, $data);
        if ($response->ok()) return collect($response->json());
    }

    public function findUserID($details)
    {
        $url = '/user';
        $data = $this->getContent($url);
        $data = $this->getFilteredContent($data, ['username', $details]);
        $user = $data->first();
        return $user['id'];
    }

    public function findGroupID($details)
    {
        $url = '/group';
        $data = $this->getContent($url);   
        $data = $this->getFilteredContent($data, ['name', $details]);
        $group = $data->first();
        return $group['id'];
    }

    public function getFilteredContent($data, $filter)
    {
        if ($filter[0] == '') return $data;

        return $data->filter(function ($d) use ($filter) {
            list($attr, $val) = $filter;
            return $d[$attr] == $val;
        });
    }

    public function formatOutput($model, $fields)
    {
        $string = '';
        foreach ($fields as $key => $field) {
            $space = ($key !== 0) ? ' ' : '';
            $string .= $space . $model[$field];
        }
        return $string;
    }
}
