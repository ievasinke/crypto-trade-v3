<?php

namespace App;

use Medoo\Medoo;

class CoingeckoApiClient implements ApiClient
{
    public static function load(): array
    {
        $database = new Medoo([
            'type' => 'sqlite',
            'database' => 'storage/database.sqlite'
        ]);

        $currenciesData = $database->select('currency', '*');

        return array_map(function (array $currency): CryptoCurrency {
            $id = $currency['id'] ?? 0;
            $name = $currency['name'] ?? 'Unknown';
            $symbol = isset($currency['symbol']) ? strtoupper($currency['symbol']) : 'UNKNOWN';
            $price = $currency['price'] ?? 0.0;

            return new CryptoCurrency($id, $name, $symbol, $price);
        }, $currenciesData);
        //        exit("Run: 'php importGecko.php' to fetch data.\n");
    }
}