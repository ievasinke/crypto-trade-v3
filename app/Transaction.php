<?php

namespace App;

class Transaction implements \JsonSerializable
{
    private string $type;
    private string $name;
    private string $symbol;
    private float $quantity;
    private float $price;
    private string $date;

    public function __construct(
        string $type,
        string $name,
        string $symbol,
        float  $quantity,
        float  $price)
    {
        $this->type = $type;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->date = date('Y-m-d H:i:s');
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
            'name' => $this->name,
            'symbol' => $this->symbol,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'date' => $this->date
        ];
    }
}
