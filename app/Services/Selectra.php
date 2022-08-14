<?php

namespace App\Services;

use App\Models\Core\Bank;

class Selectra
{
    public \Illuminate\Http\Client\PendingRequest $client;

    public function __construct()
    {
        $this->client = \Http::withToken(config('services.selectra.token'));
    }

    public function getBankByIban($iban): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|Bank|null
    {
        $call = $this->client->post('https://api.selectra.com/api/iban/getbic', ['iban' => $iban])->object();
        $bank =  Bank::where('name', 'LIKE', '%'.$call->bank_name.'%')->first();

        if($bank->bic == null) {
            $bank->update([
                'bic' => $call->bic
            ]);
        }

        return $bank;
    }
}
