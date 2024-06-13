<?php

require_once('vendor/autoload.php');

use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required([
    'COIN_GEKO_API_KEY',
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
            'x-cg-demo-api-key' => $_ENV['COIN_GEKO_API_KEY'],
        ],
    ]);

$response->getStatusCode();

file_put_contents('data/crypto.json', $response->getBody());

