<?php

namespace App;


class CoingeckoApiClient implements ApiClient
{
    public static function load(string $cryptoFile = 'data/crypto.json'): array
    {
        if (($cryptoDataContents = @file_get_contents($cryptoFile)) === false) {
            exit("Run: 'php importGecko.php' to fetch data.\n");
        }
        $cryptoData = json_decode($cryptoDataContents);
        return array_map(function ($crypto) {
            return new CryptoCurrency($crypto->name, strtoupper($crypto->symbol), $crypto->current_price);
        }, $cryptoData);
    }
}