<?php

namespace App;

class CoinmarketApiClient implements ApiClient
{
    public static function load(string $cryptoFile = 'data/crypto.json'): array
    {
        $cryptoData = json_decode(file_get_contents($cryptoFile));

        return array_map(function ($crypto) {
            return new CryptoCurrency($crypto->name, $crypto->symbol, $crypto->quote->USD->price);
        }, $cryptoData->data);
    }
}