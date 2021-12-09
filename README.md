## About
This service is PHP API SDK for zoning service.

## Installation

`composer require dotsplatform/zoning-api-php-sdk`

## Usage

```
$client = new ZoningApiClient(
    config('services.zoning.host')
);

$companies = $client->getNearestCompaniesIdsBySortedByDistance(
    'uuid-account-id',
    51.35,
    31.454,
);
```
