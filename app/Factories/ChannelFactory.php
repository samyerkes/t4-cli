<?php

namespace App\Factories;

use App\Command;
use App\Models\Channel;
use App\Traits\T4able;

class ChannelFactory {

    use T4able;

    public function generate($data) 
    {
        $channels = collect([]);
        foreach ($data as $channel) 
        {
            $channelDTO = new Channel;
            $channelDTO = $channelDTO->fill($channel);
            $channels->push($channelDTO);
        }
        return $channels;
    }
}