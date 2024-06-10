<?php

namespace App;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

class TransactionManager
{
    public static function displayList($cryptoCurrencies): void
    {
        $outputCrypto = new ConsoleOutput();
        $tableCryptoCurrencies = new Table($outputCrypto);
        $tableCryptoCurrencies
            ->setHeaders(['Index', 'Name', 'Symbol', 'Price']);
        $tableCryptoCurrencies
            ->setRows(array_map(function (int $index, CryptoCurrency $cryptoCurrency): array {
                return [
                    $index + 1,
                    $cryptoCurrency->getName(),
                    $cryptoCurrency->getSymbol(),
                    new TableCell(
                        number_format($cryptoCurrency->getPrice(), 4),
                        ['style' => new TableCellStyle(['align' => 'right',])]
                    ),

                ];
            }, array_keys($cryptoCurrencies), $cryptoCurrencies));
        $tableCryptoCurrencies->setStyle('box-double');
        $tableCryptoCurrencies->render();
    }

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