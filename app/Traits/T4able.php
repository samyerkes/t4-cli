<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

Trait T4able
{
    // Defaults to a get request if other arguments are not provided
    public function sendRequest($url, $method='get', $data=[]) {
        $method = strtolower($method);
        $t4key = config('t4.token');
        $t4webapi = config('t4.webapi');
        $response = Http::withToken($t4key)->$method($t4webapi . $url, $data);
        
        if (!$response->ok()) {
            $this->error($response);
        }

        return collect($response->json());
    }

    public function findUserID($details)
    {
        $url = '/user';
        $data = $this->sendRequest($url);
        $data = $data->filter(function($d) use ($details) {
            return $d['username'] == $details;
        });
        $data = array_values($data->toArray());
        return $data[0]['id'];
    }

    public function findGroupID($details)
    {
        $url = '/group';
        $data = $this->sendRequest($url);   
        $data = $data->filter(function($d) use ($details) {
            return $d['name'] == $details;
        });
        $data = array_values($data->toArray());
        return $data[0]['id'];
    }

}
