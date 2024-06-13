<?php

namespace App;

interface ApiClient
{
    /**
     * @return array<CryptoCurrency>
     */
    public static function load(string $cryptoFile = 'data/crypto.json'): array;
}