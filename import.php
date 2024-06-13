<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

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

file_put_contents('data/crypto.json', $response->getBody());