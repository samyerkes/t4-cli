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
        return collect($response->json());
    }

}
