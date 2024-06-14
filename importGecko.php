<?php

require_once('vendor/autoload.php');

use GuzzleHttp\Client;
use Medoo\Medoo;

$database = new Medoo([
    'type' => 'sqlite',
    'database' => 'storage/database.sqlite'
]);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required([
    'COIN_GECKO_API_KEY',
]);

$client = new Client();
$baseUrl = 'https://api.coingecko.com/api/v3/coins/markets';
$parameters = [
    'vs_currency' => 'USD',
    'per_page' => '20',
];

$response = $client->request(
    'GET',
    $baseUrl,
    [
        'query' => $parameters,
        'headers' => [
            'accept' => 'application/json',
            'x-cg-demo-api-key' => $_ENV['COIN_GECKO_API_KEY'],
        ],
    ]);
$currenciesData = $response->getBody()->getContents();

$currencies = json_decode($currenciesData);

foreach ($currencies as $currency) {
    $currency = [
        "name" => $currency->name,
        "symbol" => $currency->symbol,
        "price" => $currency->current_price
    ];
    $currencyExists = $database->has('currency', ['name' => $currency['name']]);
    if ($currencyExists) {
        $database->update('currency', $currency, ['name' => $currency['name']]);
        echo "Currency updated.\n";
    } else {
        $database->insert('currency', $currency);
        echo "Currency inserted.\n";
    }
}
