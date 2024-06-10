<?php

namespace App;

class CryptoCurrency
{
    private string $name;
    private string $symbol;
    private float $price;

    public function __construct(string $name, string $symbol, float $price)
    {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public static function load(string $cryptoFile = 'data/crypto.json'): array
    {
        $cryptoData = json_decode(file_get_contents($cryptoFile));

        return array_map(function ($crypto) {
            return new CryptoCurrency($crypto->name, $crypto->symbol, $crypto->quote->USD->price);
        }, $cryptoData->data);
    }
}