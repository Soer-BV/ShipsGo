# ShipsGo
PHP Client for the ShipsGo API

Install via composer:
````
composer require soerbv/shipsgo
````

Usage:
````php
$client = new Client($authCode);
$data = $client->getVoyageData('ContainerNumber');
print_r(json_decode($data));
````
