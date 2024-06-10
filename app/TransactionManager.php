<?php

namespace App;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class TransactionManager
{
    public static function viewWallet(Wallet $wallet): void
    {
        $output = new ConsoleOutput();
        $tableWallet = new Table($output);
        $tableWallet
            ->setHeaders(['Currency', 'Quantity', 'Total amount (USD)']);
        $tableWallet
            ->setRows(array_map(function (string $symbol, array $details): array {
                return [
                    $symbol,
                    $details['quantity'],
                    number_format($details['totalAmount'], 2)
                ];
            }, array_keys($wallet->getPortfolio()), $wallet->getPortfolio()));
        $tableWallet->setStyle('box');
        $tableWallet->render();
    }
}