<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command as LaravelCommand;

Trait T4
{
    // Defaults to a get request if other arguments are not provided
    public function sendRequest($url, $method='get', $data=[]) {
        $method = strtolower($method);
        $t4key = config('t4.token');
        $t4webapi = config('t4.webapi');
        $response = Http::withToken($t4key)->$method($t4webapi . $url, $data);
        if ($response->ok()) return collect($response->json());
    }

    public function findUserID($details)
    {
        $url = '/user';
        $data = $this->sendRequest($url);
        $data = $this->getFilteredContent($data, ['username', $details]);
        $user = $data->first();
        return $user['id'];
    }

    public function findGroupID($details)
    {
        $url = '/group';
        $data = $this->sendRequest($url);   
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
