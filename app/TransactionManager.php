<?php

namespace App;

use Exception;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

class TransactionManager
{
    public static function displayList(array $cryptoCurrencies): void
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
        $portfolios = array_filter($wallet->getPortfolio(), function (array $items): bool {
            return $items['quantity'] > 0;
        });

        $output = new ConsoleOutput();
        $tableWallet = new Table($output);
        $tableWallet
            ->setHeaders(['Currency', 'Quantity', 'Total amount (USD)']);
        $tableWallet
            ->setRows(array_map(function (string $symbol, array $items): array {
                return [
                    $symbol,
                    $items['quantity'],
                    number_format($items['totalAmount'], 2)
                ];
            }, array_keys($portfolios), $portfolios));
        $tableWallet->setStyle('box');
        $tableWallet->render();
        $total = number_format($wallet->getBalance(), 2);
        echo "You have \$$total in your wallet\n";
    }

    public static function buy(array $cryptoCurrencies, Wallet $wallet): void
    {

        self::displayList($cryptoCurrencies);
        $index = (int)readline("Enter the index of the crypto currency to buy: ") - 1;
        $quantity = (float)readline("Enter the quantity: ");
        $type = 'buy';

        if (isset($cryptoCurrencies[$index])) {
            $currency = $cryptoCurrencies[$index];
            $price = $currency->getPrice();
            $totalAmount = $price * $quantity;

            try {
                $wallet->addCurrency($currency->getSymbol(), $quantity, $price);
                self::logTransaction(
                    $type,
                    $currency->getName(),
                    $currency->getSymbol(),
                    $quantity,
                    $price,
                );
                echo "You bought {$currency->getName()} for \$$totalAmount\n";
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
            return;
        }
        echo "Invalid index.\n";
    }

    public static function sell(array $cryptoCurrencies, Wallet $wallet): void
    {
        self::viewWallet($wallet);

        if (count($wallet->getPortfolio()) === 0) {
            echo "There are no items in your wallet.\n";
            return;
        }

        $symbol = strtoupper((string)readline("Enter the symbol of the currency: "));
        $quantity = (float)readline("Enter the quantity to sell: ");
        $type = 'sell';

        foreach ($cryptoCurrencies as $currency) {
            if ($currency->getSymbol() === $symbol) {
                $price = $currency->getPrice();

                try {
                    $wallet->sellCurrency($symbol, $quantity, $price);
                    self::logTransaction($type, $currency->getName(), $currency->getSymbol(), $quantity, $price);
                    $amount = number_format($quantity * $price, 2);
                    echo "You sold {$currency->getName()} for \$$amount\n";
                } catch (Exception $e) {
                    echo $e->getMessage() . PHP_EOL;
                }
                return;
            }
        }
        echo "Invalid symbol.\n";
    }

    public static function displayTransactionList(string $transactionsFile): void
    {
        $transactionsData = file_exists($transactionsFile) ? json_decode(file_get_contents($transactionsFile)) : [];
        $transactions = array_map('App\Transaction::deserialize', $transactionsData);
        $output = new ConsoleOutput();
        $tableTransactions = new Table($output);
        $tableTransactions
            ->setHeaders(['Type', 'Name', 'Symbol', 'Quantity', 'Price', 'Date']);
        $tableTransactions
            ->setRows(array_map(function (Transaction $transaction): array {
                return [
                    $transaction->getType(),
                    $transaction->getName(),
                    $transaction->getSymbol(),
                    $transaction->getQuantity(),
                    number_format($transaction->getPrice(), 2),
                    $transaction->getDate(),
                ];
            }, $transactions));
        $tableTransactions->setStyle('box');
        $tableTransactions->render();
    }

    private static function logTransaction(
        string $type,
        string $currency,
        string $symbol,
        float  $quantity,
        float  $price
    ): void
    {
        $transactionsFile = 'data/transactions.json';
        $transactions = file_exists($transactionsFile)
            ? json_decode(file_get_contents($transactionsFile))
            : [];
        $transactions[] = new Transaction($type, $currency, $symbol, $quantity, $price);
        file_put_contents($transactionsFile, json_encode($transactions, JSON_PRETTY_PRINT));
    }
}