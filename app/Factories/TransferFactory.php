<?php

namespace App\Factories;

use App\Command;
use App\Models\Transfer;
use App\Traits\T4able;

class TransferFactory {

    use T4able;

    public function generate($data) 
    {
        $transfers = collect([]);
        foreach ($data as $transfer) 
        {
            $transferDTO = new Transfer;
            $transferDTO = $transferDTO->fill($transfer);
            $transfers->push($transferDTO);
        }
        return $transfers;
    }
}