# ShipsGo
PHP Client for the ShipsGo API

Install via composer:
````
composer require soerbv/shipsgo
````

## Usage:

Set client:
````php
$client = new Client($authCode);
````

Create a tracking request with BL:
````php
$client->createTrackingWithBl('CONTAINER_NUMBER', 'SHIPPING_LINE', 'EMAIL_ADDRESS', 'REFERENCE_NO', 'BL_CONTAINERS_REF');
````

Create a tracking request with Container Number:
````php
$client->createTrackingWithContainerNumber('CONTAINER_NUMBER', 'SHIPPING_LINE', 'EMAIL_ADDRESS', 'REFERENCE_NO');
````

Get Voyage Data:
````php
$data = $client->getVoyageData('CONTAINER_NUMBER');
print_r(json_decode($data));
````
