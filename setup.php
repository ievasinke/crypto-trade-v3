<?php

require 'vendor/autoload.php';

use Medoo\Medoo;

$database = new Medoo([
    'type' => 'sqlite',
    'database' => 'storage/database.sqlite'
]);

// CryptoCurrency
$database->query("CREATE TABLE IF NOT EXISTS currency (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        symbol TEXT,
        price REAL
    )");

// Wallet
$database->query("CREATE TABLE IF NOT EXISTS wallet (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        balance REAL,
        portfolio TEXT
    )");

// Transaction
$database->query("CREATE TABLE IF NOT EXISTS transactions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        type TEXT,
        currency TEXT,
        symbol TEXT,
        quantity REAL,
        price REAL,
        date TEXT
    )");

echo "Database schema initialized.\n";
