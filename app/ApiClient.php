<?php

namespace App;

interface ApiClient
{
    /**
     * @return array<CryptoCurrency>
     */
    public static function load(): array;
}