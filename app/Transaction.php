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
        string  $type,
        string  $name,
        string  $symbol,
        float   $quantity,
        float   $price,
        ?string $date)
    {
        $this->type = $type;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->date = $date ?? date('Y-m-d H:i:s');
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDate(): string
    {
        return $this->date;
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

    public function deserialize($object): Transaction
    {
        return new self(
            $object->type,
            $object->name,
            $object->symbol,
            $object->quantity,
            $object->price,
            $object->date
        );
    }
}
