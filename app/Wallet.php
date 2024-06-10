<?php

namespace App;

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

    private function load(): void
    {
        $walletData = json_decode(file_get_contents($this->walletFile));
        $this->balance = $walletData->balance;
        $this->portfolio = $walletData->portfolio;
    }

    private function save(): void
    {
        file_put_contents($this->walletFile, json_encode($this));
    }

    public function jsonSerialize(): array
    {
        return [
            'balance' => $this->balance,
            'portfolio' => $this->portfolio
        ];
    }
}