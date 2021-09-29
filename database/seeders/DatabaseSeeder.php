<?php

namespace Database\Seeders;

use App\Services\Api\CurrencyService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('currencies')->count() == 0) {
            DB::table('currencies')->insert([
                ['name' => 'EUR', 'base' => true],
                ['name' => 'USD', 'base' => false],
                ['name' => 'GBP', 'base' => false]
            ]);
        }

        $currencyService = new CurrencyService();
        $currencyService->writeCurrencies();
    }
}
