<?php

namespace App;

use Exception;
use JsonSerializable;

class Wallet implements JsonSerializable
{
    private float $balance;
    private array $portfolio;
    private string $walletFile;

    public function __construct(string $walletFile = 'data/wallet.json')
    {
        $this->balance = 1000;
        $this->walletFile = $walletFile;
        $this->portfolio = [];

        if (file_exists($walletFile)) {
            $this->load();
        }
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getPortfolio(): array
    {
        return $this->portfolio;
    }

    public function addCurrency(string $symbol, float $quantity, float $price): void
    {
        $totalCost = $price * $quantity;

        if ($totalCost > $this->balance) {
            throw new Exception("Not enough balance to buy $symbol.");
        }

        if (isset($this->portfolio[$symbol]) && $this->portfolio[$symbol]['quantity'] > 0) {
            $this->portfolio[$symbol]['quantity'] += $quantity;
            $this->portfolio[$symbol]['totalAmount'] += $totalCost;
        } else {
            $this->portfolio[$symbol] = [
                'quantity' => $quantity,
                'totalAmount' => $totalCost
            ];
        }
        $this->balance -= $totalCost;
        $this->save();
    }

    public function sellCurrency(string $symbol, float $quantity, float $price): void
    {
        if (!isset($this->portfolio[$symbol]) || $this->portfolio[$symbol]['quantity'] < $quantity) {
            throw new Exception("Not enough quantity to sell $symbol.");
        }

        $this->portfolio[$symbol]['quantity'] -= $quantity;
        $totalAmount = $price * $quantity;
        $this->portfolio[$symbol]['totalAmount'] -= $totalAmount;

        if ($this->portfolio[$symbol]['quantity'] == 0) {
            unset($this->portfolio[$symbol]);
        }

        $this->balance += $totalAmount;
        $this->save();
    }

    private function load(): void
    {
        $walletData = json_decode(file_get_contents($this->walletFile), true);
        $this->balance = $walletData['balance'];
        $this->portfolio = $walletData['portfolio'];
    }

    private function save(): void
    {
        file_put_contents($this->walletFile, json_encode($this, JSON_PRETTY_PRINT));
    }

    public function jsonSerialize(): array
    {
        return [
            'balance' => $this->balance,
            'portfolio' => $this->portfolio
        ];
    }
}