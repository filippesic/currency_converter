<?php

namespace App\Http\Controllers;

use App\Services\Api\CurrencyService;

class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $currencyService = new CurrencyService();

        return response()->json($currencyService->ratioCalculation());
    }

    public function getCurrencies()
    {
        return response()->json($this->currencyService->getCurrencies());
    }

    public function getCurrencyRatios()
    {
        return response()->json($this->currencyService->getCurrencyRatios());
    }
}
