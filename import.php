<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use Medoo\Medoo;

$database = new Medoo([
    'type' => 'sqlite',
    'database' => 'storage/database.sqlite'
]);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required([
    'CRYPTO_API_KEY',
]);

$client = new Client();
$baseUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$parameters = [
    'start' => '1',
    'limit' => '20',
    'convert' => 'USD'
];

$response = $client->request(
    'GET',
    $baseUrl,
    [
        'query' => $parameters,
        'headers' => [
            'Accepts' => 'application/json',
            'X-CMC_PRO_API_KEY' => $_ENV['CRYPTO_API_KEY']
        ]
    ]
);
$response->getStatusCode();

$currenciesData = $response->getBody()->getContents();

$currencies = json_decode($currenciesData);
(var_export($currencies));
//die;
foreach ($currencies->data as $currency) {
    $currency = [
        "name" => $currency->name,
        "symbol" => $currency->symbol,
        "price" => $currency->quote->USD->price
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
