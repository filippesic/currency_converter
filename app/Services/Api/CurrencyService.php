<?php

namespace App\Services\Api;

use App\Models\Currency;
use App\Models\CurrencyRatio;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    protected $data;

    protected function setData()
    {
        $this->data = Http::get(env('FIXERIO_BASE_URL') . 'latest', [
            'access_key' => env('FIXERIO_ACCESS_KEY'),
            'base' => 'EUR',
            'symbols' => 'EUR,USD,GBP'
        ])->json();
    }

    public function getCurrencies()
    {
        return Currency::all();
    }

    public function getCurrencyRatios()
    {
        return CurrencyRatio::all();
    }

    public function writeCurrencies()
    {
        $this->setData();

        $apiTime = Carbon::createFromTimestamp($this->data['timestamp'])->toDateTimeString();

        if (CurrencyRatio::count() < 21) {
            CurrencyRatio::insert([
                [
                    'currency_id' => 1,
                    'ratio' => $this->data['rates']['EUR'],
                    'api_timestamp' => $apiTime,
                    'created_at' => now()
                ],
                [
                    'currency_id' => 2,
                    'ratio' => $this->data['rates']['USD'],
                    'api_timestamp' => $apiTime,
                    'created_at' => now()
                ],
                [
                    'currency_id' => 3,
                    'ratio' => $this->data['rates']['GBP'],
                    'api_timestamp' => $apiTime,
                    'created_at' => now()
                ]
            ]);
        } else {
            CurrencyRatio::with('currency')
                ->where('created_at', '<=', now()->subDays(7)->startOfDay())
                ->get()
                ->map(function ($ratio) {
                    return $ratio->update([
                        'ratio' => $this->data['rates'][$ratio->currency->name],
                        'api_timestamp' => Carbon::createFromTimestamp($this->data['timestamp'])->toDateTimeString()
                    ]);
                });
        }
    }

    public function ratioCalculation()
    {
        $currencies = Currency::with('ratio')->get();
        $response = [];

        foreach ($currencies as $currencyOne) {
            $pairCombo = [];
            $comboRatio = null;

            foreach ($currencies as $currencyTwo) {
                $pairCombo = [$currencyOne->id, $currencyTwo->id];

                if ($currencyOne->base === true) {
                    $comboRatio = $currencyOne->ratio->ratio;
                } else if (($currencyOne->base && $currencyTwo->base) !== true) {
                    $comboRatio = (1 / $currencyOne->ratio->ratio) / (1 / $currencyTwo->ratio->ratio);
                } else {
                    $comboRatio = 1 / $currencyOne->ratio->ratio;
                }

                array_push($response, ['pair' => $pairCombo, 'ratio' => $comboRatio]);
            }
        }

        return $response;
    }
}
