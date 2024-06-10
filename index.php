<?php
require_once 'vendor/autoload.php';

use App\Wallet;
use App\TransactionManager;
use GuzzleHttp\Client;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();
$dotenv->required([
    'CRYPTO_API_KEY',
]);

if (empty('data/crypto.json')) {
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
}

$resource = json_decode(file_get_contents('data/crypto.json'));
$cryptoCurrencies = $resource->data;
$wallet = new Wallet();

while (true) {
    $outputTasks = new ConsoleOutput();
    $tableActivities = new Table($outputTasks);
    $tableActivities
        ->setHeaders(['Index', 'Action'])
        ->setRows([
            ['1', 'Show list of top currencies'],
            ['2', 'Wallet'],
            ['3', 'Sell'],
            ['4', 'Buy'],
            ['5', 'Display transaction list'], //based on transaction history, that is saved in .json file
            ['0', 'Exit'],
        ])
        ->render();
    $action = (int)readline("Enter the index of the action: ");

    if ($action === 0) {
        break;
    }

    switch ($action) {
        case 1: //Show list of top currencies
            TransactionManager::displayList($cryptoCurrencies);
            break;
        case 2: //Wallet
            TransactionManager::viewWallet($wallet);
            break;
        case 3: //Sell
            break;
        case 4: //Buy
            break;
        case 5: //Display transaction list
            break;
        default:
            break;


    }
}
