<?php

namespace App\Traits;

use Exception;
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
            die();
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
    
    // Return a collection of attributes based on the model type and and needle type detail you provide.
    public function getDetails($model, $detail)
    {
        $detail = is_array($detail) ? $detail : [$detail];

        $attr = ['id', 'name'];

        // This is basically a big router
        switch($model) {
            case ('apikey'):
                $url = __('api.keys.index');
                break;
            case ('channel'):
                $url = __('api.channel.index');
                break;
            case ('channelmicrosite'):
                $url = __('api.channel.index');
                break;
            case ('contenttype'):
                $url = __('api.contenttype.index');
                $attr = ['id', 'alias'];
                break;
            case ('group'):
                $url = __('api.group.index');
                break;
            case ('groupmember'):
                $url = __('api.group.show', ['group' => $detail['id']]);
                $attr = ['id', 'username'];
                break;
            case ('layout'):
                $url = __('api.layout.index');
                break;
            case ('navigation'):
                $url = __('api.navigation.index');
                break;
            case ('notification'):
                $url = __('api.notification.index');
                break;
            case ('schedule'):
                $url = __('api.schedule.index');
                break;
            case ('transfer'):
                $url = __('api.transfer.index');
                break;
            case ('usergroup'):
                $url = __('api.user.groups', ['user' => $detail['id']]);
                break;
            default:
                $url = __('api.user.index');
                $attr = ['id', 'username'];
                break;
        }
        
        $data = $this->sendRequest($url);  

        // Get microsites of channels, this is kinda lame / a hack and could be cleaned up.
        if ($model == 'channelmicrosite') {
            $microsites = $data->map(function($d) {
                return $d['microSites'];
            })->flatten(1);

            $data = $data->merge($microsites);
        }

        // Get nested data for groupmembers, this is kinda lame I have to do this for this specific model.
        if ($model == 'groupmember') $data = collect($data['members']);
        
        // If we have passed in a detail then we want to filter the data.
        if (!empty($detail)) {

            $data = $data->filter(function($d) use ($attr, $detail) {
                foreach($attr as $a) {
                    if (in_array($d[$a], $detail)) return true;
                }
            });

        }

        return $data->values();
    }

}
