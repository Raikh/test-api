Example Usage:
~~~~
<?php

use Onigae\TestApi\DebitCard\ClientApi;
use Onigae\TestApi\DebitCard\Config;

require_once './vendor/autoload.php';

$config = new Config(
    [
        'base_uri' => 'https://google.com/',
        'timeout' => 60,
        'headers' => [
            'AUTH-KEY' => 'AUTH-KEY-STRING',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]
    ]
);
$clientApi = new ClientApi($config);
$card = $test->createCard(
    [
        'first_name',
        'last_name',
        'address',
        'city',
        'country_id',
        'phone',
        'currency',
        'balance',
    ]
);

$card_pin = $clientApi->getPin(15);
$card_pin = $card->getPin();
~~~~