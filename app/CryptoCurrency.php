<?php

namespace App;

class CryptoCurrency
{
    private int $id;
    private string $name;
    private string $symbol;
    private float $price;

    public function __construct(int $id, string $name, string $symbol, float $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
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
}